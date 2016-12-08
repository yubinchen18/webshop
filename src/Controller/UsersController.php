<?php
namespace App\Controller;

use App\Controller\AppController;

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
                    return $this->redirectAfterLogin();
                } else {
                    $this->emptyFieldsMessage();
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
                    //pr($this->Auth->user()); die;
                    //check for duplicate users
                    if (in_array($extraUser['id'], $loggedInUsers)) {
                        if ($this->request->data['login-type'] === 'login-extra-child') {
                            $this->Flash->set(__('Kind al ingelogd.'), [
                                'element' => 'default',
                                'params' => ['class' => 'error']
                            ], 'auth');
                        }
                        return $this->redirectAfterLogin();
                    }
                    //write all users to session key
                    $loggedInUsers[] = $extraUser['id'];
                    $session->write('LoggedInUsers.AllUsers', $loggedInUsers);
                    return $this->redirectAfterLogin();
                } else {
                    if (empty($this->request->data['username']) && empty($this->request->data['password'])) {
                        return $this->redirectAfterLogin();
                    }
                    
                    $this->emptyFieldsMessage();
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
    
    private function redirectAfterLogin()
    {
        if ($this->request->data['login-type'] === 'login-extra-child') {
            return $this->redirect($this->Auth->config('loginAction'));
        }
        
        $this->request->session()->write('loginSuccessful', true);        
        return $this->redirect(array('controller' => 'Photos', 'action' => 'index'));
    }
    
    private function emptyFieldsMessage()
    {
        if (empty($this->request->data['username']) || empty($this->request->data['password'])) {
            $this->Flash->set(__('De gebruikersnaam of inlogcode is niet ingevuld'), [
                'element' => 'default',
                'params' => ['class' => 'error']
            ], 'auth');
        } else {
            $this->Flash->set(__('Het inloggen is mislukt. Probeer het nogmaals.'), [
               'element' => 'default',
               'params' => ['class' => 'error']
            ], 'auth');
        }
    }

    public function logout()
    {
        $this->Flash->set(__('Het uitloggen is succesvol'), [
            'element' => 'default',
            'params' => ['class' => 'success']
        ]);
        
        if ($this->request->session()->check('loginSuccessful')) {
            $this->request->session()->delete('loginSuccessful');
        }
        
        //clear extra users data from session
        if ($this->request->session()->read('LoggedInUsers')) {
            $this->request->session()->delete('LoggedInUsers');
        }
        return $this->redirect($this->Auth->logout());
    }
}
