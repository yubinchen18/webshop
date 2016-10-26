<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Network\Exception\BadRequestException;
use Cake\Routing\Router;
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
        $this->loadComponent('CakeIdeal.CakeIdeal',[
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
        if(!$this->request->is('post')) {
            throw new BadRequestException();
        }
        $this->Carts = TableRegistry::get('Carts');
        $cart = $this->Carts->find('byUserid', ['user_id' => $this->Auth->user('id')])->first();
        $totals = $this->Carts->getCartTotals($cart->id);
        $data = $this->request->data;
     
        $invAddress = $this->Orders->Invoiceaddresses->getAddressId($data);
        if($data['different-address'] == 1) {
            $deliveryAddress = $this->Orders->Deliveryaddresses->getAddressId($data['alternative']);
        }
        $orderData = [
            'user_id' => $cart->user_id,
            'totalprice' => $totals['products'],
            'shippingcosts'=> $totals['shippingcosts'],
            'payment_method' => $data['paymentmethod'],
            'invoiceaddress_id' => $invAddress,
            'deliveryaddress_id' => !empty($deliveryAddress) ? $deliveryAddress : $invAddress
        ];
        
        $order = $this->Orders->newEntity($orderData);
        if(!$this->Orders->save($order)) {
            $this->Flash->error(__("Uw bestelling kon niet worden opgeslagen"));
            return $this->redirect(['controller' => 'carts', 'action' => 'orderInfo']);
        }
        
        foreach($cart->cartlines as $line) {
            $productoptions = [];
            foreach($line->cartline_productoptions as $option) {
                $productoptions[] = ['productoption_choice_id' => $option->productoption_choice_id];
            }
            
            $orderline = [
                'article' => $line->product->article,
                'productname' => $line->product->name,
                'quantity' => $line->quantity,
                'price_ex' => $line->product->price_ex,
                'vat' => $line->product->vat,
                'exported' => 0,
                'order_id' => $order->id,
                'photo_id' => $line->photo_id,
                'product_id' => $line->product_id,
            ];
            if(!empty($productoptions)) {
                $orderline['orderline_productoptions'] = $productoptions;
            }
            $line = $this->Orders->Orderlines->newEntity($orderline, ['associated' => ['OrderlineProductoptions']]);
            if(!$this->Orders->Orderlines->save($line)) {
                $this->Orders->delete($order);
                $this->Flash->error(__("Uw bestelling kon niet worden opgeslagen"));
                return $this->redirect(['controller' => 'carts', 'action' => 'orderInfo']);
            }
        }
        
        switch ($order->payment_method) {
            default:
                return $this->redirect(['controller' => 'orders', 'action' => 'success']);
                break;
                
            case "ideal":
                $this->request->session()->write('order', $order);
                return $this->redirect(['controller' => 'orders', 'action' => 'payment']);
                break;
        }
    }
    
    public function payment()
    {
        $issuers = $this->CakeIdeal->sendDirectoryRequest();
        
        $order = $this->request->session()->read('order');
        $ordertotal = ($order->totalprice + $order->shippingcosts);
        
        if($this->request->is('post')) {
            $trxData = [
                        'Issuer' => [
                                'issuerId' =>  $this->request->data['issuer']
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
        
        $this->set(compact('issuers'));
    }
    
    public function idealResult()
    {
        $order = $this->request->session()->read('order');
        $data['Transaction']['transactionId'] = $order->trx_id;
        
        $result = $this->CakeIdeal->sendStatusRequest($data);
        
        if($result['Transaction']['status'] == 'Success') {
            $trx['ideal_status'] = 'Success';
            $this->Orders->patchEntity($order, $trx);
            if($this->Orders->save($order)) {
                $this->Flash->success(__('Uw betaling is succesvol verwerkt'));
                return $this->redirect(['controller' => 'orders', 'action' => 'success']);
            }
            
            @mail('support@xseeding.nl','iDeal betaling niet opgeslagen',
                    'Een ideal betaling kon niet verwerkt worden.<br/> Hoogstraten ' . __FILE__);
            $this->Flash->success(__('Uw betaling is verwerkt, maar kon niet worden doorgevoerd in het systeem\n'
                    . 'Er is een servicebericht verzonden naar de systeembeheerder'));
            return $this->redirect(['controller' => 'orders', 'action' => 'success']);
        }
        
        $this->Flash->error(__('De verwerking van uw betaling is mislukt. Probeer het opnieuw'));
        return $this->redirect(['controller' => 'orders', 'action' => 'failure']);
    }
    
    public function success()
    {
        $order = $this->request->session()->read('order');
        
        $this->request->session()->write('order',null);
        $cart = $this->Orders->Carts->find('byUserid',['user_id' => $this->Auth->user('id')])->first();
        $newcart = $this->Orders->Carts->patchEntity($cart,['order_id' => $order->id]);
        $this->Orders->Carts->save($newcart);
        $this->set(compact('order'));
    }
    
    public function failure()
    {
        $this->set(compact('order'));
    }
}
 