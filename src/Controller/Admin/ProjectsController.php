<?php
namespace App\Controller\Admin;

use App\Controller\AppController\Admin;
use Cake\Event\Event;
use App\Lib\PDFCardCreator;

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
    public function index()
    {
        $this->paginate = [
            'contain' => ['Schools', 'Groups']
        ];
        $projects = $this->paginate($this->Projects);
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

        $this->set('project', $project);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $project = $this->Projects->newEntity();
        $schools = $this->Projects->Schools->find('list');
        if ($this->request->is('post')) {
            $project = $this->Projects->patchEntity($project, $this->request->data);
            if ($this->Projects->save($project)) {
                $this->Flash->success(__('Het project is opgeslagen.'));
                return $this->redirect(['action' => 'index']);
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
        $project = $this->Projects->get($id, [
            'contain' => ['Schools']
        ]);
        $schools = $this->Projects->Schools->find('list');
        if ($this->request->is(['patch', 'post', 'put'])) {
            if (isset($this->request->data['differentmail']) && $this->request->data['differentmail'] == 0) {
                $this->Projects->Mailaddresses->delete($project->mailaddress);
                $project->mailladdress = null;
            }
            
            $project = $this->Projects->patchEntity($project, $this->request->data);
            if ($this->Projects->save($project)) {
                $this->Flash->success(__('Het project is opgeslagen.'));
                return $this->redirect(['action' => 'index']);
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
