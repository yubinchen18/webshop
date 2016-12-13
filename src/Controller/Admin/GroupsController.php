<?php
namespace App\Controller\Admin;

use App\Controller\AppController\Admin;
use Cake\Event\Event;
use App\Lib\PDFCardCreator;

/**
 * Groups Controller
 *
 * @property \App\Model\Table\GroupsTable $Groups
 */
class GroupsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Projects.Schools', 'Barcodes', 'Persons']
        ];
        $groups = $this->paginate($this->Groups);
        $this->set(compact('groups'));
    }
    
    /**
     * Fetch all groups for a project
     * @param type $project_id
     */
    public function projectgroups($project_id)
    {
        $groups = $this->Groups->find('list')
                ->where(['Groups.project_id' => $project_id])
                ->orderAsc('Groups.name');
        
        $this->set(compact('groups'));
    }
    
    /**
     * View method
     *
     * @param string|null $id Group id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $group = $this->Groups->get($id, [
             'contain' => ['Projects.Schools', 'Barcodes', 'Persons', 'Projects']
        ]);
                
        $this->set('group', $group);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $group = $this->Groups->newEntity();
        $projects = $this->Groups->Projects->find('list')->orderAsc('name');
        if ($this->request->is('post')) {
            $group = $this->Groups->patchEntity($group, $this->request->data);
            if ($this->Groups->save($group)) {
                $this->Flash->success(__('De group is opgeslagen.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('De groep kon niet opgeslagen worden. Probeer het nogmaals.'));
            }
        }
        $this->set(compact('group', 'projects'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Group id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $group = $this->Groups->get($id);
        $projects = $this->Groups->Projects->find('list');
        $barcodes = $this->Groups->Barcodes->find('list');
        if ($this->request->is(['patch', 'post', 'put'])) {
            if (isset($this->request->data['differentmail']) && $this->request->data['differentmail'] == 0) {
                $this->Groups->Mailaddresses->delete($group->mailaddress);
                $group->mailladdress = null;
            }
            
            $group = $this->Groups->patchEntity($group, $this->request->data);
            if ($this->Groups->save($group)) {
                $this->Flash->success(__('De groep is opgeslagen.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('De groep kon niet opgeslagen worden. Probeer het nogmaals.'));
            }
        }
        $this->set(compact('group', 'projects', 'barcodes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Group id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $group = $this->Groups->get($id);
        if ($this->Groups->delete($group)) {
            $this->Flash->success(__('De groep is verwijderd.'));
        } else {
            $this->Flash->error(__('De groep kon niet verwijderd worden.  Probeer het nogmaals.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    
    /**
     * Create cards for all inside group
     *
     * @param type $id
     * @return PDF
     */
    public function createGroupCards($id = null)
    {
        $this->viewBuilder()->layout(false);
        
        //Load the person data
        $data = $this->Groups->get($id, [
            'contain' => [
                'Barcodes',
                'Projects.Schools',
                'Persons' => [
                    'Groups.Projects.Schools', 'Addresses', 'Barcodes', 'Users'
                ]
            ]
        ]);

        new PDFCardCreator($data);
    }
    
    public function getStudentsByGroup($id = null)
    {
        $groups =  $this->Groups->get($id, [
           'contain' => ['Persons', 'Projects']
        ]);
        $this->set(compact('groups', $groups));
    }
}
