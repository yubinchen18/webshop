<?php
namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['login', 'forgot','register']);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
//        pr($this->request->session()->read());
        $this->paginate = [
            'contain' => ['Addresses']
        ];
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Addresses', 'Orders', 'OrdersOrderstatuses', 'Persons']
        ]);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $this->request->data['real_pass'] = $this->request->data['password'];
            $user = $this->Users->patchEntity($user, $this->request->data);
            
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $addresses = $this->Users->Addresses->find('list', ['limit' => 200]);
        $this->set(compact('user', 'addresses'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        unset($user->password);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->request->data['real_pass'] = $this->request->data['password'];
            if(empty($this->request->data['password'])) {
                unset($this->request->data['password']);
                unset($this->request->data['real_pass']);
            }
            
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $addresses = $this->Users->Addresses->find('list', ['limit' => 200]);
        $this->set(compact('user', 'addresses'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function login()
    {
        if ($this->request->is('post')) {
           $user = $this->Auth->identify();
           if ($user) {
               $this->Auth->setUser($user);
               $this->Flash->set(__('You have successfully signed in.'), [
                   'element' => 'default',
                   'params' => ['class' => 'success']
               ]);
               return $this->redirect($this->Auth->redirectUrl());
           } else {
               $this->Flash->set(__('You could not sign in. Please, try again.'), [
                   'element' => 'default',
                   'params' => ['class' => 'error']
               ], 'auth');
               return $this->redirect(['action' => 'login']);
           }
       }
        $this->render(false);
    }
}
