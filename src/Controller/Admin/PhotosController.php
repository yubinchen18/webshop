<?php
namespace App\Controller\Admin;

use App\Controller\AppController\Admin;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

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
        $this->paginate = array(
            'contain' => array(
                'Barcodes.Persons.Groups.Projects',
                'Barcodes.Groups.Projects'
            ),
            'limit' => 24,
            'order' => array(
                'Photos.created'
            )
        );
        
        $schools = $this->Photos->Barcodes->Persons->Groups->Projects->Schools->find('list');        
        $projects = [__('Selecteer een school')];
        $groups = [__('Selecteer een project')];
        $data = $this->request->data;
        $query = $this->Photos->find()
            ->contain([
                'Barcodes.Persons.Groups.Projects',
                'Barcodes.Groups.Projects'
            ]);
        
        if ($this->request->is('post')) {
            if (!empty($data['school_id']) && empty($data['project_id']) && empty($data['group_id'])) {
                $barcodes = $this->Photos->Barcodes->getBarcodesList('Persons.Groups.Projects.Schools', 'Schools.id', $data['school_id']);
                $barcodes += $this->Photos->Barcodes->getBarcodesList('Groups.Projects.Schools', 'Schools.id', $data['school_id']);
                $query->where(['Barcodes.id IN' => $barcodes]);
            }            
            if (!empty($data['project_id']) && empty($data['group_id'])) {
                $barcodes = $this->Photos->Barcodes->getBarcodesList('Persons.Groups.Projects', 'Projects.id', $data['project_id']);
                $barcodes += $this->Photos->Barcodes->getBarcodesList('Groups.Projects', 'Projects.id', $data['project_id']);
                $query->where(['Barcodes.id IN' => $barcodes]);
            }
            if (!empty($data['group_id'])) {
                $barcodes = $this->Photos->Barcodes->getBarcodesList('Persons.Groups', 'Groups.id', $data['group_id']);
                $barcodes += $this->Photos->Barcodes->getBarcodesList('Groups', 'Groups.id', $data['group_id']);
                $query->where(['Barcodes.id IN' => $barcodes]);
            }
            
            if(!empty($data['school_id']))
            {
                $projects = $this->Photos->Barcodes->Persons->Groups->Projects->find('list')
                    ->where(['Projects.school_id' => $data['school_id']]);
                $projects = (count($projects->toArray()) == 0) ? [__('Geen projecten voor deze school')] : $projects;
            }
            if(!empty($data['project_id']))
            {
                $groups = $this->Photos->Barcodes->Persons->Groups->find('list')
                    ->where(['Groups.project_id' => $data['project_id']]);
                $groups = (count($groups->toArray()) == 0) ? [__('Geen klassen voor dit project')] : $groups;
            }
        }
        
        $photos = $this->paginate($query);
        
        $this->set(compact('photos', 'schools', 'projects', 'groups'));
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
    
    public function display($size, $id)
    {
        $photo = $this->Photos->find()
              ->where(['id' => $id])
              ->first();
        
        $file = $this->Photos
                ->getPath($photo->barcode_id) . DS . $size . DS . $photo->path;
        
        $this->response->type(['jpg' => 'image/jpeg']);
        $this->response->file($file, ['name' => 'path']);
        return $this->response;
    }
    
    public function move()
    {
        if (!$this->request->is('post')) {
            return $this->redirect(['action' => 'index']);
        }
        
        if (!empty($this->request->data['destination_id'])) {
            $person = $this->Photos->Barcodes->Persons->get($this->request->data['destination_id']);
            
            foreach ($this->request->data['photos'] as $photo_id) {
                $photo = $this->Photos->get($photo_id);
                $oldPath = $this->Photos->getPath($photo->barcode_id);
                $photo->barcode_id = $person->barcode_id;
                if ($this->Photos->save($photo)) {
                    // move folder to new path
                    if (isset($oldPath)) {
                        $this->Photos->move($oldPath, $photo);
                    }
                }
            }
            $this->Flash->success(__('De foto is verplaatst'));
            return $this->redirect(['controller' => 'photos','action' => 'index']);
        }

        $moves = [];
        foreach ($this->request->data['photos'] as $id => $checked) {
            if ($checked == 1) {
                $photo = $this->Photos->get($id, ['contain' => ['Barcodes.Persons.Groups.Projects']]);
                $moves[] = $photo;
            }
        }
        
        $schools = TableRegistry::get('Schools');
        $tree = $schools->find('tree', [
            'school_id' => $photo->barcode->person->group->project->school_id,
        ])->first();
        
        $this->set(compact('moves', 'tree'));
    }
}
