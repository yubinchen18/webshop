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
//        pr($session->read('Auth'));
        if (!$this->Auth->user()) {
            if ($this->request->is('post')) {
                $user = $this->Auth->identify();
                if ($user) {
                    $this->Auth->setUser($user);
                    $data = $session->read('Auth.AllUsers');
                    $data[] = $user;
                    $session->write('Auth.AllUsers', $data);
                    return $this->redirect($this->Auth->redirectUrl());
                } else {
                    $this->Flash->set(__('Het inloggen is mislukt. Probeer het nogmaals.'), [
                       'element' => 'default',
                       'params' => ['class' => 'error']
                    ], 'auth');
                    return $this->redirect(['action' => 'login']);
                }
            }
        } else {
            // Already logged in with valid user
            // identify extra user
            if ($this->request->is('post')) {
                $extraUser = $this->Auth->identify();
                if ($extraUser) {
                    $data = $session->read('Auth.AllUsers');
                    $data[] = $extraUser;
                    $session->write('Auth.AllUsers', $data);
                    return $this->redirect(['action' => 'login']);
                } else {
                    $this->Flash->set(__('Het inloggen is mislukt. Probeer het nogmaals.'), [
                       'element' => 'default',
                       'params' => ['class' => 'error']
                    ], 'auth');
                    return $this->redirect(['action' => 'login']);
                }
            }
            
            // fetch logged in user photo
            $allUsers = $session->read('Auth.AllUsers');
            foreach ($allUsers as $loggedUser) {
                $person = $this->Users->Persons->find()
                    ->where(['user_id' => $loggedUser['id']])
                    ->contain(['Barcodes.Photos'])
                    ->first();
                $photo = $person->barcode->photos[0];
                // add orientation data to photo object
                $filePath = $this->Users->Persons->Barcodes->Photos->getPath($person->barcode_id) . DS . $photo->path;
                $dimensions = getimagesize($filePath);
                if ($dimensions[0] > $dimensions[1]) {
                    $orientationClass = 'photos-horizontal';
                } else {
                    $orientationClass = 'photos-vertical';
                }
                $photo->orientationClass = $orientationClass;
                $photos[] = $photo;
            }
            
//            pr($photos);
            $this->set(compact('photos', 'allUsers'));
            $this->set('_serialize', ['photo']);
        }
        //        $this->render(false);
    }
        


    public function logout()
    {
        $this->Flash->set(__('Het uitloggen is succesvol'), [
            'element' => 'default',
            'params' => ['class' => 'success']
        ]);
        
        //clear extra users data from session
        if ($this->request->session()->read('Auth.AllUsers')) {
            $this->request->session()->destroy('Auth.AllUsers');
        }
        return $this->redirect($this->Auth->logout());
    }
}
