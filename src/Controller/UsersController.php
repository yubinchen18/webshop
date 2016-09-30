<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use App\Controller\PhotosController;

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
        if (!$this->Auth->user()) {
            if ($this->request->is('post')) {
                $user = $this->Auth->identify();
                if ($user) {
                    $this->Auth->setUser($user);
                    $data = $session->read('LoggedInUsers.AllUsers');
                    $data[] = $user['id'];
                    $session->write('LoggedInUsers.AllUsers', $data);
                    $session->write('LoggedInUsers.ActiveUser', $user['id']);
                    return $this->redirect($this->Auth->config('loginAction'));
                } else {
                    $this->Flash->set(__('Het inloggen is mislukt. Probeer het nogmaals.'), [
                       'element' => 'default',
                       'params' => ['class' => 'error']
                    ], 'auth');
                    return $this->redirect($this->Auth->config('loginAction'));
                }
            }
        } else {
            // Already logged in with valid user
            // identify extra user
            if ($this->request->is('post')) {
                $loggedInUsers = $session->read('LoggedInUsers.AllUsers');
                $extraUser = $this->Auth->identify();
                if ($extraUser) {
                    //check for duplicate users
                    if (in_array($extraUser['id'], $loggedInUsers)) {
                        $this->Flash->set(__('Kind al ingelogd.'), [
                            'element' => 'default',
                            'params' => ['class' => 'error']
                        ], 'auth');
                        return $this->redirect($this->Auth->config('loginAction'));
                    }
                    //write all users to session key
                    $loggedInUsers[] = $extraUser['id'];
                    $session->write('LoggedInUsers.AllUsers', $loggedInUsers);
                    return $this->redirect($this->Auth->config('loginAction'));
                } else {
                    $this->Flash->set(__('Het inloggen is mislukt. Probeer het nogmaals.'), [
                       'element' => 'default',
                       'params' => ['class' => 'error']
                    ], 'auth');
                    return $this->redirect($this->Auth->config('loginAction'));
                }
            }
            
            // fetch logged in user portrait
            $allUsers = $session->read('LoggedInUsers.AllUsers');
            $photos = [];
            foreach ($allUsers as $loggedUser) {
                $photos[] = $this->Users->getUserPortrait($loggedUser);
            }
            $this->set(compact('photos', 'allUsers'));
            $this->set('_serialize', ['photo']);
        }
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
