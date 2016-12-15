<?php
namespace App\Controller\Admin;

use App\Controller\AppController\Admin;
use Cake\Event\Event;
use App\Lib\PDFCardCreator;
use App\Lib\GroupImporter;
use Cake\ORM\TableRegistry;

/**
 * Projects Controller
 *
 * @property \App\Model\Table\ProjectsTable $Projects
 */
class ProjectsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index($school_id = null)
    {
        $this->paginate = [
            'contain' => ['Schools', 'Groups.Persons']
        ];
        $projects = $this->paginate($this->Projects);
        $this->set(compact('projects'));
    }

    /**
     * Fetches all projects for a school
     * @param type $school_id
     */
    public function schoolprojects($school_id)
    {
        $projects = $this->Projects->find('list')
                ->where(['Projects.school_id' => $school_id])
                ->orderAsc('Projects.name');
        
        $this->set(compact('projects'));
    }
    
    /**
     * View method
     *
     * @param string|null $id Project id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $project = $this->Projects->get($id, [
            'contain' => ['Schools', 'Groups']
        ]);

        $this->Users = TableRegistry::get('Users');
        $profiles = $this->Users->find()->select(['username','type'])->where(['type IN ' => ['photographer','admin']]);
        foreach ($profiles as $profile) {
            $photographers[$profile->username] = $profile->username;
        }
        $this->set(compact('photographers','project'));
    }
    
    public function enableSync()
    {
        if(empty($this->request->data['project_id']) || empty($this->request->data['photographer'])) {
            return $this->redirect(['action' => 'index']); 
        }
        
        $project = $this->Projects->get($this->request->data['project_id'], [
            'contain' => ['Schools','Groups.Persons']
        ]);

        // First add school to queue
        $queues[] = [
                'profile_name' => $this->request->data['photographer'],
                'model' => 'Schools',
                'foreign_key' => $project->school_id
            ];
        
        // Add the project to queue
        $queues[] = [
                'profile_name' => $this->request->data['photographer'],
                'model' => 'Projects',
                'foreign_key' => $project->id
            ];
        
        // Add the groups to queue
        foreach($project->groups as $group) {
            $queues[] = [
                    'profile_name' => $this->request->data['photographer'],
                    'model' => 'Groups',
                    'foreign_key' => $group->id
                ];
            
            $queues[] = [
                    'profile_name' => $this->request->data['photographer'],
                    'model' => 'Barcodes',
                    'foreign_key' => $group->barcode_id
                ];
            
            // Add the persons to queue
            foreach($group->persons as $person) {
                $queues[] = [
                    'profile_name' => $this->request->data['photographer'],
                    'model' => 'Persons',
                    'foreign_key' => $person->id
                ];
            
            $queues[] = [
                    'profile_name' => $this->request->data['photographer'],
                    'model' => 'Barcodes',
                    'foreign_key' => $person->barcode_id
                ];
            }
        }
        
        $downloadQueue = TableRegistry::get('Downloadqueues');
        $entities = $downloadQueue->newEntities($queues);
        if($downloadQueue->saveMany($entities)) {
            $this->Flash->success(__("Het project is in de wachtrij geplaatst, u kunt nu synchroniseren"));
            return $this->redirect(['action' => 'view', $project->id]);
        }
        
        $this->Flash->error(__("Het project kon niet in de wachtrij worden geplaatst"));
        return $this->redirect(['action' => 'view', $project->id]);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $project = $this->Projects->newEntity();
        $schools = $this->Projects->Schools->find('list')->orderAsc('name');
        if ($this->request->is('post')) {
            $project = $this->Projects->patchEntity($project, $this->request->data);
            if ($this->Projects->save($project)) {
                $this->Flash->success(__('Het project is opgeslagen.'));
                return $this->redirect($this->referer());
            } else {
                $this->Flash->error(__('Het project kon niet opgeslagen worden. Probeer het nogmaals.'));
            }
        }
        $this->set(compact('project', 'schools'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Project id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $project = $this->Projects->newEntity();
        if (!empty($id)) {
            $project = $this->Projects->get($id, [
                'contain' => ['Schools']
            ]);
        }
        
        $schools = $this->Projects->Schools->find('list');
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            if (isset($this->request->data['differentmail']) && $this->request->data['differentmail'] == 0) {
                $this->Projects->Mailaddresses->delete($project->mailaddress);
                $project->mailladdress = null;
            }
            new GroupImporter($this->request->data, $project->school_id);
            $project = $this->Projects->patchEntity($project, $this->request->data);
            if ($this->Projects->save($project)) {
                $this->Flash->success(__('Het project is opgeslagen.'));
                return $this->redirect($this->referer());
            } else {
                $this->Flash->error(__('Het project kon niet opgeslagen worden. Probeer het nogmaals.'));
            }
        }
        $this->set(compact('project', 'schools'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Project id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $project = $this->Projects->get($id, [
            'contain' => ['Schools']
        ]);
        if ($this->Projects->delete($project)) {
            $this->Flash->success(__('Het project is verwijderd.'));
        } else {
            $this->Flash->error(__('Het project kon niet verwijderd worden.  Probeer het nogmaals.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    
    /**
     * Create cards for all inside project
     *
     * @param type $id
     * @return PDF
     */
    public function createProjectCards($id = null)
    {
        $this->viewBuilder()->layout(false);
        
        //Load the project data
        $data = $this->Projects->get($id, [
            'contain' => ['Groups'=> [
                'Barcodes',
                'Projects.Schools',
                'Persons' => ['Groups.Projects.Schools', 'Addresses', 'Barcodes', 'Users']
                ]
            ]
        ]);
        
        //Call helper create PDF
        new PDFCardCreator($data);
    }
}
