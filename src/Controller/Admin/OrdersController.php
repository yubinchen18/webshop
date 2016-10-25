<?php
namespace App\Controller\Admin;

use App\Controller\AppController\Admin;

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
                'Orderstatuses' => function($q) {
                    return $q
                        ->order(['OrdersOrderstatuses.created' => 'DESC'])
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
                'Orderstatuses', 
                'Invoices', 
                'Orderlines', 
                'PhotexDownloads'
            ]
        ]);

        $this->set('order', $order);
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
        $order = $this->Orders->get($id, [
            'contain' => ['Orderstatuses']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
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
