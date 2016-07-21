<?php
namespace App\Controller\Admin;

use App\Controller\AppController\Admin;
use Cake\Event\Event;

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
        $this->paginate = [
            'contain' => ['Barcodes.Persons.Groups.Projects'],
            'limit' => 24,
            'order' => [
                'Photos.created'
            ]
        ];
        
        $schools = $this->Photos->Barcodes->Persons->Groups->Projects->Schools
                ->find('list');
        
        $projects = [__('Selecteer een school')];
        $groups = [__('Selecteer een project')];
        
        $query = $this->Photos->find();
        if($this->request->is('post')) {
            if(!empty($this->request->data['school_id'])) {
                $query->where(['Projects.school_id' => $this->request->data['school_id']]);
                $projects = $this->Photos->Barcodes->Persons->Groups->Projects
                        ->find('list')
                        ->where(['Projects.school_id' => $this->request->data['school_id']]);
            }
            if(!empty($this->request->data['project_id'])) {
                $query->andWhere(['Projects.id' => $this->request->data['project_id']]);
                $groups = $this->Photos->Barcodes->Persons->Groups
                        ->find('list')
                        ->where(['Groups.project_id' => $this->request->data['project_id']]);
            }
            if(!empty($this->request->data['group_id'])) {
                $query->andWhere(['Groups.id' => $this->request->data['group_id']]);
            }
        }
        
        $photos = $this->paginate($query);
        
        $this->set(compact('photos', 'schools','projects', 'groups'));
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
    
    public function display($size, $path)
    {
        $photo = $this->Photos->find()
              ->where(['path' => $path])
              ->first();
        
        $file =     APP . 'userphotos' . DS .
                    $this->Photos->getPath($photo->barcode_id) . DS . 
                    $photo->path;

        $photo = new \Imagick($file);
        $thumb = $this->Photos->autoRotateImage($photo, $size);
        
        $this->response->type(['jpg' => 'image/jpeg']);
        $this->response->file($thumb,['name' => 'path']);
        return $this->response;
    }
}
