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
                $loggedInUsers = $session->read('LoggedInUsers.AllUsers');
                $extraUser = $this->Auth->identify();
                if ($extraUser) {
                    //check for duplicate users
                    if (in_array($extraUser['id'], $loggedInUsers)) {
                        $this->Flash->set(__('Kind al ingelogd.'), [
                            'element' => 'default',
                            'params' => ['class' => 'error']
                        ], 'auth');
                        return $this->redirect(['action' => 'login']);
                    }
                    //write all users to session key
                    $loggedInUsers[] = $extraUser['id'];
                    $session->write('LoggedInUsers.AllUsers', $loggedInUsers);
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
            $allUsers = $session->read('LoggedInUsers.AllUsers');
            $photos = [];
            foreach ($allUsers as $loggedUser) {
                $photo = null;
                $person = $this->Users->Persons->find()
                    ->where(['user_id' => $loggedUser])
                    ->contain(['Barcodes.Photos'])
                    ->first();
                if ($person) {
                    $dbPhotos = $person->barcode->photos;
                    if(!empty($dbPhotos)) {
                        $photo = $dbPhotos[0];
                        // add orientation data to photo object
                        $filePath = $this->Users->Persons->Barcodes->Photos->getPath($person->barcode_id) . DS . $photo->path;
                        $dimensions = getimagesize($filePath);
                        if ($dimensions[0] > $dimensions[1]) {
                            $orientationClass = 'photos-horizontal';
                        } else {
                            $orientationClass = 'photos-vertical';
                        }
                        $photo->orientationClass = $orientationClass;
                    }
                }
                $photos[] = $photo;
            }
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
        if ($this->request->session()->read('LoggedInUsers')) {
            $this->request->session()->destroy('LoggedInUsers');
        }
        return $this->redirect($this->Auth->logout());
    }
    
    public static function getUserPortrait($userId)
    {
        $photo = null;
        $usersTable = TableRegistry::get('Users');
        $person = $usersTable->Persons->find()
            ->where(['user_id' => $userId])
            ->contain(['Barcodes.Photos'])
            ->first();
        if ($person) {
            $dbPhotos = $person->barcode->photos;
            if(!empty($dbPhotos)) {
                $photo = $dbPhotos[0];
                // add orientation data to photo object
                $filePath = $usersTable->Persons->Barcodes->Photos->getPath($person->barcode_id) . DS . $photo->path;
                $dimensions = getimagesize($filePath);
                if ($dimensions[0] > $dimensions[1]) {
                    $orientationClass = 'photos-horizontal';
                } else {
                    $orientationClass = 'photos-vertical';
                }
                $photo->orientationClass = $orientationClass;
            }
        }
        return $photo;
    }
}
