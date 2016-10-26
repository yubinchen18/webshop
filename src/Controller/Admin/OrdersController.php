<?php
namespace App\Controller\Admin;

use App\Controller\AppController\Admin;
use Cake\Network\Exception\NotFoundException;

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
        $this->paginate = [
            'contain' => [
                'OrdersOrderstatuses' => function($q) {
                    return $q
                        ->order(['OrdersOrderstatuses.created' => 'DESC'])
                        ->contain(['Orderstatuses'])
                        ->limit(1);
                },
                'Orderlines.OrderlineProductoptions',
                'Users.Persons.Groups.Projects.Schools',
                'Deliveryaddresses',
                'Invoiceaddresses'
            ]
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
                'OrdersOrderstatuses' => function($q) {
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
            if($orderline->product->has_discount === 1) {
                $orderline->discountprice = 3.78;
            }
        }
        
        $orderstatuses = $this->Orders->Orderstatuses
                ->find()
                ->all();
        foreach ($orderstatuses as $orderstatus) {
            $statusOptions[$orderstatus->id] = $orderstatus->name;
        }
        
        $this->set(compact('order', 'statusOptions'));
        $this->set('_serialize', ['order']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $order = $this->Orders->newEntity();
        if ($this->request->is('post')) {
            $order = $this->Orders->patchEntity($order, $this->request->data);
            if ($this->Orders->save($order)) {
                $this->Flash->success(__('The order has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The order could not be saved. Please, try again.'));
            }
        }
        $users = $this->Orders->Users->find('list', ['limit' => 200]);
        $deliveryaddresses = $this->Orders->Deliveryaddresses->find('list', ['limit' => 200]);
        $invoiceaddresses = $this->Orders->Invoiceaddresses->find('list', ['limit' => 200]);
        $trxes = $this->Orders->Trxes->find('list', ['limit' => 200]);
        $orderstatuses = $this->Orders->Orderstatuses->find('list', ['limit' => 200]);
        $this->set(compact('order', 'users', 'deliveryaddresses', 'invoiceaddresses', 'trxes', 'orderstatuses'));
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

    /**
     * Delete method
     *
     * @param string|null $id Order id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $order = $this->Orders->get($id);
        if ($this->Orders->delete($order)) {
            $this->Flash->success(__('The order has been deleted.'));
        } else {
            $this->Flash->error(__('The order could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
