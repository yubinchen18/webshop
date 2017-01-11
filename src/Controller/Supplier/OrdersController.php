<?php
namespace App\Controller\Supplier;

use App\Controller\AppController\Supplier;
use Cake\Network\Exception\NotFoundException;
use Cake\Core\Configure;
use ZipArchive;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\ORM\TableRegistry;
use App\Lib\ImageHandler;

/**
 * Orders Controller
 *
 * @property \App\Model\Table\OrdersTable $Orders
 */
class OrdersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $lastCreated = 'SELECT MAX(created) FROM orders_orderstatuses as OOST WHERE OOST.order_id = Orders.id';
        $sentToPhotex = $this->Orders->OrdersOrderstatuses->Orderstatuses->find('byAlias', ['alias' => 'sent_to_photex'])->first()->id;
        $sentToCustomer = $this->Orders->OrdersOrderstatuses->Orderstatuses->find('byAlias', ['alias' => 'sent_to_customer'])->first()->id;
        $inTreatmentByPhotex = $this->Orders->OrdersOrderstatuses->Orderstatuses->find('byAlias', ['alias' => 'in_treatment_by_photex'])->first()->id;

        $this->paginate = [
            'contain' => [
                'OrdersOrderstatuses' => function ($q) {
                    return $q
                        ->order(['OrdersOrderstatuses.created' => 'DESC'])
                        ->contain(['Orderstatuses'])
                        ->limit(1);
                },
                'Orderlines.OrderlineProductoptions',
                'Users.Persons.Groups.Projects.Schools',
                'Deliveryaddresses',
                'Invoiceaddresses'
            ],
            'join' => [
                'table' => 'orders_orderstatuses',
                'alias' => 'OrdersOrderstatuses',
                'conditions' => [
                    'OrdersOrderstatuses.order_id = `Orders`.`id`',
                    'OrdersOrderstatuses.orderstatus_id IN' => [$sentToPhotex, $inTreatmentByPhotex],
                    sprintf('OrdersOrderstatuses.created = (%s)', $lastCreated)
                ],
                'type' => 'INNER'
            ],
            'order' => ['Orders.created' => 'DESC']
        ];
                    
        $orders = $this->paginate($this->Orders);
        $this->set(compact('orders'));
        $this->set('_serialize', ['orders']);
    }

    /**
     * View method
     *
     * @param string|null $id Order id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $order = $this->Orders->get($id, [
            'contain' => [
                'Users',
                'Deliveryaddresses',
                'Invoiceaddresses',
                'OrdersOrderstatuses' => function ($q) {
                    return $q
                        ->order(['OrdersOrderstatuses.created' => 'DESC'])
                        ->contain(['Orderstatuses']);
                },
                'Invoices',
                'Orderlines.OrderlineProductoptions.ProductoptionChoices.Productoptions',
                'Orderlines.Photos',
                'Orderlines.Products',
                'PhotexDownloads'
            ]
        ]);
        if (empty($order)) {
            throw new NotFoundException('Can\'t find order');
        }
        foreach ($order->orderlines as $orderline) {
            if ($orderline->product->has_discount === 1) {
                $orderline->discountprice = Configure::read('DiscountPrice');
            }
        }
        
        $orderstatuses = $this->Orders->OrdersOrderstatuses->Orderstatuses
                ->find()
                ->where(['alias IN' => ['sent_to_photex', 'sent_to_customer', 'in_treatment_by_photex']])
                ->all();
        
        foreach ($orderstatuses as $orderstatus) {
            $statusOptions[$orderstatus->id] = $orderstatus->name;
        }
        
        $this->set(compact('order', 'statusOptions'));
        $this->set('_serialize', ['order']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Order id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if ($this->request->is('ajax') && !empty($this->request->data)) {
            $postData = $this->request->data();
            $order = $this->Orders->find()
                ->where(['Orders.id' => $id])
                ->first();
            
            if (empty($order)) {
                $response = ['success' => false, 'message' => __('Order not found')];
                $this->set(compact('response'));
                $this->set('_serialize', 'response');
                return;
            };
            $ordersOrderstatus = $this->Orders->OrdersOrderstatuses->newEntity();
            $ordersOrderstatus->order_id = $id;
            $ordersOrderstatus->orderstatus_id = $postData['orderstatus_id'];
            $ordersOrderstatus->user_id = $this->Auth->user('id');
            if (!$this->Orders->OrdersOrderstatuses->save($ordersOrderstatus)) {
                $response = ['success' => false, 'message' => __('Could not save new orderstatus')];
                $this->set(compact('response'));
                $this->set('_serialize', 'response');
                return;
            }
            //get new order
            $orderstatusChange = $this->Orders->OrdersOrderstatuses->find()
                    ->where(['order_id' => $id])
                    ->order(['OrdersOrderstatuses.created' => 'DESC'])
                    ->contain(['Orderstatuses'])
                    ->first();
            // format datetime
            $orderstatusChange->formattedCreated = $orderstatusChange->created->format('d-m-y H:i');
            $response = [
                'success' => true,
                'orderstatusChange' => $orderstatusChange,
                'message' => 'Orderstatus updated',
            ];
            $this->set(compact('response'));
            $this->set('_serialize', 'response');
            return;
        }
        $response = ['success' => false, 'message' => __('Invalid method error')];
        $this->set(compact('response'));
        $this->set('_serialize', 'response');
    }
    
    public function download($orderId = null)
    {
        //open zip file
        $zipFile = new \ZipArchive();
        $fileName = TMP . 'zip' . DS .$orderId.'.zip';
        $folder = TMP . 'zip' . DS;

        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
        if ($zipFile->open($fileName, ZipArchive::CREATE)!==true) {
            exit("cannot open <$fileName>\n");
        }

        //add files to zip
        $orderlines = $this->Orders->Orderlines->find()->where(['order_id' => $orderId])->contain(['Products']);
        foreach ($orderlines as $line) {
            //skip digital products and funproducts
            if ($line->product->product_group === 'digital' || $line->product->product_group === 'funproducts') {
                continue;
            }
            
            $photoId = $line['photo_id'];
            $this->Photos = TableRegistry::get('Photos');
            $photo = $this->Photos->find()
                  ->where(['id' => $photoId])
                  ->first();
            $rawPath = $this->Photos->getPath($photo->barcode_id);
            $photoPath = $rawPath . DS . $photo->path;
            
            // If it's a combination sheet, create combination sheet
            if ($line->product->layout != 'LoosePrintLayout1') {
                $imageHandler = new ImageHandler();
                $photoPath = $imageHandler->createProductPreview($photo, $line->product->product_group, [
                    'resize' => ['width' => 1200, 'height' => 1796],
                    'layout' => $line->product->layout,
                ])[0]['path'];
            }
            
            //add to the zip file
            $zipFile->addFile($photoPath, $photo->path);
        }
        $zipFile->close();

        //send zip to the customer through response
        header("Content-Type: application/zip");
        header("Content-Length: " . filesize($fileName));
        header("Content-Disposition: attachment; filename=fotos.zip");
        readfile($fileName);

        unlink($fileName);
        //die or else it gives an error
        die;
    }
}
