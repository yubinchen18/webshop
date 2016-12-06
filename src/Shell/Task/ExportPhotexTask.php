<?php
namespace App\Shell\Task;

use Cake\Console\Shell;
use App\Lib\PDFCardCreator;
use App\Lib\ImageHandler;
use phpseclib\Net\SFTP;

/**
 * ExportPhotexTask shell task.
 */
class ExportPhotexTask extends Shell
{
    private $pdfLocation = '';
    private $ftpConfig = 'xseeding';
    private $server = [];
    private $ftpPackingslipsFolder = "/files/hoogstraten pakbonnen";
    private $ftpPhotosFolder = "/files/hoogstraten";
    private $useTempName = true;
    private $debug = false;
    private $data = [];
    private $deleteCache = true;
    
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Orders');
    }

    /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function main()
    {
    }

    public function find_waiting_orders() {
        $this->out("Start : " . date("d-m-Y H:i"));
        
        //find all orders that's created in last monty, with latest orderstatus alias as 'payment_received' and exportstatus is 'new'
        $openOrders = $this->Orders->findOpenOrdersForPhotex();
        $this->data['cronjobs.photex.openorders'] = count($openOrders);
        $this->data['cronjobs.photex.queue.added'] = 0;
//        debug($openOrders);die();
        foreach ($openOrders as $order) {
            //see if order is already in download queue
            $queue = $this->Orders->PhotexDownloads->find()->where(['order_id' => $order->id])->toArray();
            if (empty($queue) && $this->debug === false ) {
                //create new Photex downloadqueue
                $newQueue = $this->Orders->PhotexDownloads->newEntity([
                    'order_id' => $order->id,
                    'attempts' => 1
                ]);
                if (!$this->Orders->PhotexDownloads->save($newQueue)) {
                    $this->out("Failed to save $order->id to Photex Downloads queue");die();
                };
                //update order export status
                $order->exportstatus = 'queued';
                $this->Orders->save($order);
                $this->data['cronjobs.photex.queue.added']++;
            }
        }
        $this->out('-- Wachtrij bijgewerkt');
    }

    function process_queue() {
        //Get queued orders
        $queue = $this->Orders->PhotexDownloads->find()
            ->order(['created' => 'DESC'])
            ->limit(10)
            ->toArray();
        
        $this->data['cronjobs.photex.queue.total'] = count($queue);
        $this->data['cronjobs.photex.queue.processed'] = 0;
        //Open ftp connection
        $ftp = $this->connectFtp();
        
        //Process each orders in the queue
        foreach ($queue as $key => $queuedOrder) {
            $orderData = $this->Orders->getOrderDataForPhotex($queuedOrder->order_id);
            $orderIdent = str_pad($orderData->ident, 6, "0", STR_PAD_LEFT);
            //create packslip
            $this->pdfLocation = (new PDFCardCreator($orderData))->path;
            $this->out('Order: ' . $orderIdent);
            ftp_chdir($ftp, $this->ftpPackingslipsFolder);
            $this->out("-- Zit nu in map: " . ftp_pwd($ftp));
            $fileList = ftp_nlist($ftp, ".");
            //Upload pakbon and change temp name
            $packingslipName = $orderIdent;
            if( $this->useTempName == true ) {
                $packingslipName .= '-bezig';
            }
            $packingslipName .= '.pdf';
            if (!$fileList) {
                $fileList = [];
            }
            if (!in_array($packingslipName, $fileList)) {
                //Pakbon upload:
                if (ftp_put($ftp, $packingslipName, $this->pdfLocation, FTP_BINARY)) {
                    $this->out("-- Pakbon geupload: $packingslipName");
                } else {
                    print_r(error_get_last());
                    $this->out("! Pakbon upload mislukt: " . $this->ftpPackingslipsFolder . $packingslipName);
                    continue;
                }
            } else {
                if ( $this->debug === false ) {
                    $photexQueue = $this->Orders->PhotexDownloads->find()->where(['order_id' => $orderData->id])->first();
                    $photexQueue->attempts = $photexQueue->attempts + 1;
                    $this->Orders->PhotexDownloads->save($photexQueue);
                }
            }
            
            // Now generate the Photos and upload them (create package)
            $orderPackage = [];
            $orderPackage['orderId'] = $orderIdent;
            ftp_chdir($ftp, $this->ftpPhotosFolder);
            if (!$this->folderExists($ftp, $orderIdent)) {
                ftp_mkdir($ftp, $orderIdent);
                $this->out("-- Map gecreeerd: " . ftp_pwd($ftp) . DS . $orderIdent);
            }
            ftp_chdir($ftp, $orderIdent);
            $this->out("-- Zit nu in map: " . ftp_pwd($ftp));
            $this->out("-- Foto's aan het uploaden.");
            foreach ($orderData->orderlines as $orderline) {
                // If it's a combination sheet, create combination sheet
                if ($orderline->product->layout != 'LoosePrintLayout1') {
                    $imageHandler = new ImageHandler();
                    $sourcePath = $imageHandler->createProductPreview($orderline->photo, $orderline->product->product_group, [
                        'resize' => ['width' => 1200, 'height' => 1796],
                        'layout' => $orderline->product->layout,
                    ])[0]['path'];
                    $orderPackage['cachedPaths'][] = $sourcePath;
                // If normal pictures, get the original photo
                } else {
                    $sourcePath = $this->Orders->Orderlines->Photos->getPath($orderline->photo->barcode_id) . DS . $orderline->photo->path;
                }
                //Rename file according to rules 
                $filter = !empty($this->Orders->Orderlines->getFilter($orderline->id)) ? $this->Orders->Orderlines->getFilter($orderline->id) : 'Standaard';
                $finishing = $this->Orders->Orderlines->getFinishing($orderline->id);
                $remotePath = "{$orderline->quantity}x[{$orderline->product->article}][{$filter} ({$finishing})]-{$orderline->photo->path}";
                $orderPackage['photos'][] = ['sourcePath' => $sourcePath, 'remotePath' => $remotePath];
                
                //upload to photex
                if ( $this->debug === false ) {
                    if (ftp_put($ftp, $remotePath, $sourcePath, FTP_BINARY)) {
                        $this->out("-- Foto opgeslagen op Photex server: " . $this->ftpPhotosFolder . DS . $orderIdent . DS . $remotePath);
                        //change orderline export status
                        $orderline->exported = true;
                        if (!$this->Orders->Orderlines->save($orderline)) {
                            $this->out("Kon export status van orderline $orderline->id niet wijzigen.");
                        };
                    } else {
                        pr(error_get_last());
                        $this->out("Kon bestand niet opslaan op Photex server: " . $this->ftpPhotosFolder . $orderIdent . DS . $remotePath);
                    }
                }
            }
            
            // Check and update status
            ftp_chdir($ftp, $this->ftpPackingslipsFolder);
            if (ftp_rename($ftp, $packingslipName, $orderIdent.".pdf")) {
                $this->out("-- Pakbon hernoemd: " . $orderIdent.".pdf");
            } else {
                $this->out("Rename mislukt: " . $orderIdent.".pdf");
            }
            $packingslipName = $orderIdent.".pdf";
            if ( $this->debug === false ) {
                // delete from Photex Downloadqueue
                if ($this->Orders->PhotexDownloads->delete($queuedOrder)) {
                    $this->out('-- Order uit Photex Download queue verwijderd.');
                } else {
                    $this->out('Kon Photex Download queue niet verwijderen.');
                };
                //Change orderstatus to sent to photex and exportstatus success
                $systemUser = $this->Orders->Users->getSystemUser();
                $newOrderstatus = $this->Orders->OrdersOrderstatuses->newEntity([
                    'order_id' => $queuedOrder->order_id,
                    'orderstatus_id' => 
                        $this->Orders->OrdersOrderstatuses->Orderstatuses->find('byAlias', ['alias' => 'sent_to_photex'])->first()->id,
                    'user_id' => $systemUser->id
                ]);
                if ($this->Orders->OrdersOrderstatuses->save($newOrderstatus)) {
                    $this->out('-- Orderstatus gewijzigd naar: Sent to Photex.');
                } else {
                    $this->out('Kon order status niet wijzigen.');
                };
                $order = $this->Orders->get($queuedOrder->order_id);
                $order->exportstatus = 'success';
                if ($this->Orders->save($order)) {
                    $this->out('-- Order exportstatus gewijzigd naar: success.');
                } else {
                    $this->out('Kon order exportstatus niet wijzigen.');
                };
                // Delete cache
                if ($this->deleteCache) {
                    unlink($this->pdfLocation);
                    if (!empty($orderPackage['cachedPaths'])) {
                        foreach ($orderPackage['cachedPaths'] as $cachedPath) {
                            unlink($cachedPath);
                        }
                    }
                    $this->out('-- Cache bestanden verwijderd.');
                }
                $this->data['cronjobs.photex.queue.processed']++;
            }
        }
        $this->disconnectFtp($ftp);
    }
    
    public function final_check() {
        $this->out('Final Check');
        if ($ftp = $this->connectFtp()) {
            $this->out("FTP verbinding gemaakt");
            ftp_chdir($ftp, $this->ftpPhotosFolder);
            $orders = ftp_nlist($ftp, ".");
            ftp_chdir($ftp, $this->ftpPackingslipsFolder);
            $aPackingSlips = ftp_nlist($ftp, ".");

            foreach( $orders as $iOrderNr ) {
                if( !is_numeric($iOrderNr)) {
                    continue;
                }
                $sStatus = 'order not found';
                $aOrder = $this->Order->find(
                    'first', 
                    array(
                        'conditions' => array(
                            'Order.id' => $iOrderNr
                        ),
                        'contain' => array(
                            'Orderline',
                            'Orderstatus' => array(
                                'order' => array(
                                    'Orderstatus.created' => 'DESC'
                                ),
                                'limit' => 1
                            )
                        )
                    )
                );

                $allExported = true;
                $isPaid = ($aOrder['Order']['paid'] == 'Y');
                $hasPackingSlip = false;
                if( $aOrder['Order']['exported'] == 'Y') {
                    $hasPackingSlip = in_array($aOrder['Order']['id'] . '.pdf', $aPackingSlips);

                    foreach( $aOrder['Orderline'] as $aOrderline ) {
                        if( $aOrderline['exported'] != 'Y') {
                            $allExported = false;
                            break;
                        }
                    } 
                } else {
                    $allExported = false;
                }

                if( !empty( $aOrder ) ) {
                    if( $isPaid ) {
                        if( !$hasPackingSlip ) {
                            $sStatus = 'missing packing slip';
                            
                            if( $this->debug === false ) {
                                $aOrder = $this->getOrderData($iOrderNr, false);
                                $this->uploadPackingSlip($aOrder, false);
                            }
                        }
                        if( !$allExported ) {
                            $sStatus = 'export failed';
                        }
                        if( $isPaid && $allExported && $hasPackingSlip ) {
                            $sStatus = 'all ok';
                            if ( $this->debug === false ) {
                                $this->Order->query("DELETE FROM photex_downloadqueue WHERE order_id = " . $aOrder['Order']['id']);
                                
                                $aExistingStatus = $this->Order->Orderstatus->find(
                                    'first', 
                                    array(
                                        'conditions' => array(
                                            'status_id' => 9, 
                                            'order_id' => $aOrder['Order']['id']
                                        ),
                                        'contain' => false
                                    )
                                );
                                if($aExistingStatus === false ) {
                                    $this->Order->Orderstatus->create();
                                    $this->Order->Orderstatus->save(array('status_id' => 9, 'order_id' => $aOrder['Order']['id']));
                                }
                            }
                        }
                    } else {
                        $sStatus = 'not paid';
                    }
                }
                $this->out($iOrderNr . ': ' . $sStatus);
            }
        }
    }
    
    private function connectFtp() {
        if( $this->ftpConfig === 'photex') {
            $this->server['host'] = "188.204.242.61";	// Live
            $this->server['port'] = 21;
            $this->server['user'] = 'ftpuser';
            $this->server['pass'] = '2141314';
            $connection = ftp_connect($photexHost, 21);
            $this->ftpPackingslipsFolder = "/ftp/hoogstraten pakbonnen";
            $this->ftpPhotosFolder = "/ftp/hoogstraten";
        }
        if( $this->ftpConfig === 'xseeding') {
            $this->server['host'] = "ftp.xseeding.nl";	// Test
            $this->server['port'] = 22;
            $this->server['user'] = 'xseedingftp';
            $this->server['pass'] = 'jk7F7W95YZjMRRRh';
            $this->ftpPackingslipsFolder = "/files/hoogstraten pakbonnen";
            $this->ftpPhotosFolder = "/files/hoogstraten";
            $connection = ftp_ssl_connect($this->server['host']);
            
        }
        if (!ftp_login($connection, $this->server['user'], $this->server['pass'])) {
            return false;
        }
        // Set timeout to 1 hour
        ftp_pasv($connection, true) or die("Cannot switch to passive mode");
        ftp_set_option($connection, FTP_TIMEOUT_SEC, 3600);
        $this->out("Verbinding met FTP server gemaakt.");
        return $connection;
    }
    
    private function disconnectFtp($connection) {
        ftp_close($connection);
        $this->out("FTP verbinding verbroken.");
    }
    
    private function folderExists($connection, $path ) {
        $oldPath = ftp_pwd($connection);
        $changeDirResult = @ftp_chdir($connection, $path);
        @ftp_chdir($connection, $oldPath);
        return $changeDirResult;
    }
}
