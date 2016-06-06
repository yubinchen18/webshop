<?php
namespace App\Controller\Admin;

use App\Controller\AppController\Admin;
use Cake\Utility\Security;
use Cake\Core\Configure;
use Cake\Event\Event;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    /**
     * beforeFilter method
     * @param  Event  $event
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $this->Auth->allow([
            'login',
        ]);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [];
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
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
        $user = $this->Users->get($id);

        $this->set('user', $user);
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
            $this->request->data['genuine'] = $this->request->data['password'];
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('De gebruiker is opgeslagen.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('De gebruiker kon niet opgeslagen worden. Probeer het nogmaals.'));
            }
        }
        $this->set(compact('user'));
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
        $user = $this->Users->get($id);
        
        unset($user->password);
        unset($user->genuine);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            if (isset($this->request->data['password'])) {
                $this->request->data['genuine'] = $this->request->data['password'];
            }
            
            if (empty($this->request->data['password'])) {
                unset($this->request->data['password']);
                unset($this->request->data['genuine']);
            }
            
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('De gebruiker is opgeslagen.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('De gebruiker kon niet opgeslagen worden. Probeer het nogmaals.'));
            }
        }
        $this->set(compact('user'));
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
        if ($id == $this->Auth->user('id')) {
            $this->Flash->error(__('Je kan niet jezelf verwijderen.'));
            return $this->redirect(['action' => 'index']);
        }
        
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('De gebruiker is verwijderd.'));
        } else {
            $this->Flash->error(__('De gebruiker kon niet verwijderd worden. Probeer het nogmaals.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                $this->Flash->set(__('Je bent succesvol ingelogd'), [
                   'element' => 'default',
                   'params' => ['class' => 'success']
                ]);
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->set(__('Het inloggen is mislukt. Probeer het nogmaals.'), [
                   'element' => 'default',
                   'params' => ['class' => 'error']
                ], 'auth');
                return $this->redirect(['action' => 'login']);
            }
        }
        $this->render(false);
    }

    public function logout()
    {
        $this->Flash->set(__('Het uitloggen is succesvol'), [
            'element' => 'default',
            'params' => ['class' => 'success']
        ]);
        return $this->redirect($this->Auth->logout());
    }
}
