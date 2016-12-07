<?php
namespace App\Controller\Supplier;

use App\Controller\AppController\Admin;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
   public function login()
    {
        $session = $this->request->session();
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                $data = $session->read('LoggedInUsers.AllUsers');
                $data[] = $user['id'];
                $session->write('LoggedInUsers.AllUsers', $data);
                $session->write('LoggedInUsers.ActiveUser', $user['id']);
                if ($user['type'] === 'photex') {
                    return $this->redirect(['controller' => 'Orders', 'action' => 'index']);
                }
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
        
        //clear extra users data from session
        if ($this->request->session()->read('LoggedInUsers')) {
            $this->request->session()->delete('LoggedInUsers');
        }
        return $this->redirect($this->Auth->logout());
    }
}
