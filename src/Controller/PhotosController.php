<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Filesystem\Folder;

/**
 * Photos Controller
 *
 * @property \App\Model\Table\PhotosTable $Photos
 */
class PhotosController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        //temporary fix for test
        $personId = '8273af3e-1fc8-44e6-ae0e-021a4a955965';
        
        $usersTable = TableRegistry::get('users');
        $personsTable = TableRegistry::get('Persons');
        $person = $personsTable->find()
                ->where(['Persons.id' => $personId])
                ->contain(['Barcodes.Photos'])
                ->first();
        
        //add the orientation data to the photos array
        foreach ($person->barcode->photos as $key => $photo) {
            $filePath = $this->Photos->getPath($person->barcode_id) . DS . $photo->path;
            $dimensions = getimagesize($filePath);
            if ($dimensions[0] > $dimensions[1]) {
                $orientationClass = 'photos-horizontal';
            } else {
                $orientationClass = 'photos-vertical';
            }
            $photo->orientationClass = $orientationClass;
        }
        
        $this->set(compact('person'));
        $this->set('_serialize', ['photos']);
    }
    
    /**
     * View method
     *
     * @param string|null $id Photo id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $photo = $this->Photos->get($id, [
            'contain' => ['Barcodes']
        ]);

        $this->set('photo', $photo);
        $this->set('_serialize', ['photo']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $photo = $this->Photos->newEntity();
        if ($this->request->is('post')) {
            $photo = $this->Photos->patchEntity($photo, $this->request->data);
            if ($this->Photos->save($photo)) {
                $this->Flash->success(__('The photo has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The photo could not be saved. Please, try again.'));
            }
        }
        $barcodes = $this->Photos->Barcodes->find('list', ['limit' => 200]);
        $this->set(compact('photo', 'barcodes'));
        $this->set('_serialize', ['photo']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Photo id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $photo = $this->Photos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $photo = $this->Photos->patchEntity($photo, $this->request->data);
            if ($this->Photos->save($photo)) {
                $this->Flash->success(__('The photo has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The photo could not be saved. Please, try again.'));
            }
        }
        $barcodes = $this->Photos->Barcodes->find('list', ['limit' => 200]);
        $this->set(compact('photo', 'barcodes'));
        $this->set('_serialize', ['photo']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Photo id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $photo = $this->Photos->get($id);
        if ($this->Photos->delete($photo)) {
            $this->Flash->success(__('The photo has been deleted.'));
        } else {
            $this->Flash->error(__('The photo could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    /**
     * 
     * @param type $size
     * @param type $id
     * @return type
     */
    public function display($size = 'original', $path)
    {
        $photo = $this->Photos->find()
              ->where(['path' => $path])
              ->first();
        
        switch ($size) {
            case "med":
                $rawPath = $this->Photos->getPath($photo->barcode_id) . DS . 'med';
                break;
            
            case "thumb":
                $rawPath = $this->Photos->getPath($photo->barcode_id) . DS . 'thumbs';
                break;
            
            default:
                $rawPath = $this->Photos->getPath($photo->barcode_id);
                break;
        }
        $file = $rawPath . DS . $photo->path;
   
        $this->response->type(['jpg' => 'image/jpeg']);
        $this->response->file($file, ['name' => 'path']);
        return $this->response;
    }
}
