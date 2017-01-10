<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Network\Exception\BadRequestException;
use Cake\Routing\Router;
use App\Lib\ImageHandler;
use ZipArchive;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Core\Configure;

/**
 * Orders Controller
 *
 * @property \App\Model\Table\OrdersTable $Orders
 */
class OrdersController extends AppController
{
    
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('CakeIdeal.CakeIdeal', [
            'certificatesFolder' => ROOT . DS . 'plugins' . DS . 'CakeIdeal' . DS . 'config' . DS . 'certificates' . DS
        ]);
    }
    
    /**
     * Add method
     *
     * @return \Cake\Network\Response|null
     */
    public function add()
    {
        if (!$this->request->is('post')) {
            throw new BadRequestException();
        }
        $this->Carts = TableRegistry::get('Carts');
        $cart = $this->Carts->find('byUserid', ['user_id' => $this->Auth->user('id')])->first();
        $totals = $this->Carts->getCartTotals($cart->id);
        $data = json_decode($this->request->data['orderData'], true);
        $invAddress = $this->Orders->Invoiceaddresses->getAddressId($data);
        if ($data['different-address'] == 1) {
            $deliveryAddress = $this->Orders->Deliveryaddresses->getAddressId($data['alternative']);
        }
        $orderData = [
            'user_id' => $cart->user_id,
            'totalprice' => $totals['products'],
            'shippingcosts'=> $totals['shippingcosts'],
            'payment_method' => $data['paymentmethod'],
            'invoiceaddress_id' => $invAddress,
            'deliveryaddress_id' => !empty($deliveryAddress) ? $deliveryAddress : $invAddress,
            'orders_orderstatuses' => [
                [
                    'orderstatus_id' => $this->Orders->OrdersOrderstatuses
                                            ->Orderstatuses->find('byAlias', ['alias' => 'new'])
                                            ->first()->id,
                    'user_id' => $this->Auth->user('id')
                ]
            ]
        ];
        
        $order = $this->Orders->newEntity($orderData);
        if (!($order = $this->Orders->save($order, ['associated' => 'OrdersOrderstatuses']))) {
            $this->Flash->error(__("Uw bestelling kon niet worden opgeslagen"));
            return $this->redirect(['controller' => 'carts', 'action' => 'orderInfo']);
        }
      
        foreach ($cart->cartlines as $line) {
            $productoptions = [];
            foreach ($line->cartline_productoptions as $option) {
                $productoptions[] = ['productoption_choice_id' => $option->productoption_choice_id];
            }
            
            $lineprice = 0;
            if ($line->product->has_discount === 1) {
                $line->discountprice = Configure::read('DiscountPrice');
                $lineprice = $line->product->price_ex;
                for ($n=2; $n<=$line->quantity; $n++) {
                    $lineprice += Configure::read('DiscountPrice');
                }
            }
            
            $orderline = [
                'article' => $line->product->article,
                'productname' => $line->product->name,
                'quantity' => $line->quantity,
                'price_ex' => $lineprice,
                'vat' => $line->product->vat,
                'exported' => 0,
                'order_id' => $order->id,
                'photo_id' => $line->photo_id,
                'product_id' => $line->product_id,
            ];
            if (!empty($productoptions)) {
                $orderline['orderline_productoptions'] = $productoptions;
            }
            
            $line = $this->Orders->Orderlines->newEntity($orderline, ['associated' => ['OrderlineProductoptions']]);
            if (!$this->Orders->Orderlines->save($line)) {
                $this->Orders->delete($order);
                $this->Flash->error(__("Uw bestelling kon niet worden opgeslagen"));
                return $this->redirect(['controller' => 'carts', 'action' => 'orderInfo']);
            }
        }
        
        $this->request->session()->write('order', $order);
        switch ($order->payment_method) {
            default:
                return $this->redirect(['controller' => 'orders', 'action' => 'success']);
                break;
                
            case "ideal":
                $this->request->session()->write('ideal-issuer', $data['issuerId']);
                return $this->redirect(['controller' => 'orders', 'action' => 'payment']);
                break;
        }
    }
    
    public function payment()
    {
        $issuer = $this->request->session()->read('ideal-issuer');
        $order = $this->request->session()->read('order');
        $ordertotal = ($order->totalprice + $order->shippingcosts);
        
        if (empty($issuer) || empty($order)) {
            $this->Flash->error(__("Niet alle benodigde gegevens zijn ingevuld"));
            return $this->redirect(['controller' => 'Carts', 'action' => 'orderInfo']);
        }
        
        $trxData = [
                    'Issuer' => [
                            'issuerId' =>  $issuer
                    ],
                    'Transaction' => [
                            'amount' => $ordertotal,
                            'entranceCode' => $order->ident,
                            'purchaseId' => date('YmdHis'),
                            'description' => sprintf('Hoogstraten fotografie order: %s', $order->ident)
                    ],
                    'Merchant' => [
                            'merchantReturnUrl' => Router::url(
                                ['controller' => 'Orders', 'action' => 'ideal_result'],
                                ['full' => true]
                            )
                    ]
            ];

        $request = $this->CakeIdeal->sendTransactionRequest($trxData);

        $order = $this->Orders->patchEntity($order, ['trx_id' => $request['Transaction']['transactionID']]);
        $this->Orders->save($order);
        $this->request->session()->write('order', $order);
        
        return $this->redirect($request['Issuer']['issuerAuthenticationURL']);
    }
    
    public function idealResult()
    {
        $order = $this->request->session()->read('order');
        $data['Transaction']['transactionId'] = $order->trx_id;
        
        $result = $this->CakeIdeal->sendStatusRequest($data);
        
        if ($result['Transaction']['status'] == 'Success') {
            $trx['ideal_status'] = 'Success';
            $trx['orders_orderstatuses'] = [
                [
                    'orderstatus_id' => $this->Orders->OrdersOrderstatuses
                                            ->Orderstatuses->find('byAlias', ['alias' => 'payment_received'])
                                            ->first()->id,
                    'user_id' => $this->Auth->user('id')
                ]
            ];
            $this->Orders->patchEntity($order, $trx);
            if ($this->Orders->save($order, ['associated' => 'OrdersOrderstatuses'])) {
                $this->Flash->success(__('Uw betaling is succesvol verwerkt'));
                return $this->redirect(['controller' => 'orders', 'action' => 'success']);
            }
            
            @mail(
                'support@xseeding.nl',
                'iDeal betaling niet opgeslagen',
                'Een ideal betaling kon niet verwerkt worden.<br/> Hoogstraten ' . __FILE__
            );
            $this->Flash->success(__('Uw betaling is verwerkt, maar kon niet worden doorgevoerd in het systeem\n'
                    . 'Er is een servicebericht verzonden naar de systeembeheerder'));
            return $this->redirect(['controller' => 'orders', 'action' => 'success']);
        }
        
        $trx['ideal_status'] = 'Failed';
        $trx['orders_orderstatuses'] = [
            [
                'orderstatus_id' => $this->Orders->OrdersOrderstatuses
                                        ->Orderstatuses->find('byAlias', ['alias' => 'payment_failed'])
                                        ->first()->id,
                'user_id' => $this->Auth->user('id')
            ]
        ];
        $this->Orders->patchEntity($order, $trx);
        $this->Orders->save($order, ['associated' => 'OrdersOrderstatuses']);
        
        $this->Flash->error(__('De verwerking van uw betaling is mislukt. Probeer het opnieuw'));
        return $this->redirect(['controller' => 'orders', 'action' => 'failure']);
    }
    
    public function success()
    {
        $order = $this->request->session()->read('order');
//        if(empty($order)) {
//            return $this->redirect(['controller' => 'photos']);
//        }
//        $this->request->session()->write('order', null);
//        $cart = $this->Orders->Carts->find('byUserid', ['user_id' => $this->Auth->user('id'), 'order_id IS NULL'])->first();
//        
//        foreach ($cart->coupons as $coupon) {
//            $this->Orders->Carts->Coupons->delete($coupon);
//        }
//        $newcart = $this->Orders->Carts->patchEntity($cart, ['order_id' => $order->id]);
//        $this->Orders->Carts->save($newcart);
        $this->Orders->sendConfirmation($order);
        $this->set(compact('order'));
    }
    
    public function failure()
    {
        $order = $this->request->session()->read('order');
        $this->Orders->sendConfirmation($order, 'failed');
        $this->set(compact('order'));
    }
    
    public function download($orderId = null)
    {
        //check if orderstatus == payment_received
        $idStatusPaid = $this->Orders->OrdersOrderstatuses
            ->Orderstatuses->find('byAlias', ['alias' => 'payment_received'])
            ->first()
            ->id;
        
        $paidOrder = $this->Orders->OrdersOrderstatuses->find()
                ->contain('Orders')
                ->where(['Orders.id' => $orderId, 'orderstatus_id' => $idStatusPaid])
                ->first();
        
        if (!$paidOrder) {
            return $this->redirect(['controller' => 'Photos', 'action' => 'index']);
        }
        
        //open zip file
        $zipFile = new ZipArchive();
        $fileName = TMP . 'zip' . DS .$orderId.'.zip';
        $folder = TMP . 'zip' . DS;
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
        if ($zipFile->open($fileName, ZipArchive::CREATE)!==true) {
            exit("cannot open <$filename>\n");
        }
        
        //add files to zip
        $orderlines = $this->Orders->Orderlines->find()->where(['order_id' => $orderId])->toArray();
        foreach ($orderlines as $line) {
            if ($line->article === 'GAF 13x19') {
                continue;
            }
            $photoId = $line['photo_id'];
            $this->Photos = TableRegistry::get('Photos');
            $photo = $this->Photos->find()
                  ->where(['id' => $photoId])
                  ->first();
            $rawPath = $this->Photos->getPath($photo->barcode_id);

            if ($line->article === 'DPack') {
                $dir = new Folder($rawPath);
                $files = $dir->find('.*\.jpg|.gif|.png');
                foreach ($files as $file) {
                    $photoPath = $rawPath . DS . $file;
                    $zipFile->addFile($photoPath, $file);
                }
            }
            if ($line->article != 'DPack') {
                $photoPath = $rawPath . DS . $photo->path;
                //add to the zip file
                $zipFile->addFile($photoPath, $photo->path);
            }
        }
        $zipFile->close();

        //send zip to the customer through response
        header("Content-Type: application/zip");
        header("Content-Length: " . filesize($fileName));
        header("Content-Disposition: attachment; filename= . $fileName");
        readfile($fileName);

        unlink($fileName);
    }
}
