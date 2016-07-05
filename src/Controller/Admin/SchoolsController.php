<?php
namespace App\Controller\Admin;

use App\Controller\AppController\Admin;
use Cake\Event\Event;
use App\Lib\GroupImporter;
/**
 * Schools Controller
 *
 * @property \App\Model\Table\SchoolsTable $Schools
 */
class SchoolsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Contacts', 'Visitaddresses', 'Mailaddresses']
        ];
        $schools = $this->paginate($this->Schools);
        $this->set(compact('schools'));
    }

    /**
     * View method
     *
     * @param string|null $id School id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $school = $this->Schools->get($id, [
            'contain' => ['Contacts', 'Visitaddresses', 'Mailaddresses']
        ]);

        $this->set('school', $school);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $school = $this->Schools->newEntity();
        if ($this->request->is('post')) {
            $school = $this->Schools->patchEntity($school, $this->request->data);
            if ($this->Schools->save($school)) {
                $this->Flash->success(__('De school is opgeslagen.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('De school kon niet opgeslagen worden. Probeer het nogmaals.'));
            }
        }
        $this->set(compact('school'));
    }

    /**
     * Edit method
     *
     * @param string|null $id School id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $school = $this->Schools->get($id, [
            'contain' => ['Contacts', 'Visitaddresses', 'Mailaddresses', 'Projects']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            if (isset($this->request->data['differentmail']) && $this->request->data['differentmail'] == 0) {
                $this->Schools->Mailaddresses->delete($school->mailaddress);
                $school->mailladdress = null;
            }

            new GroupImporter($this->request->data, $id);            
            $school = $this->Schools->patchEntity($school, $this->request->data, [
                'associated' => ['Projects']
            ]);
            if ($this->Schools->save($school)) {
                $this->Flash->success(__('De school is opgeslagen.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('De school kon niet opgeslagen worden. Probeer het nogmaals.'));
            }
        }
        $projectEntity = $this->Schools->Projects->newEntity();
        $this->set(compact('school', 'projectEntity'));
    }

    /**
     * Delete method
     *
     * @param string|null $id School id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $school = $this->Schools->get($id, [
            'contain' => ['Contacts', 'Visitaddresses', 'Mailaddresses']
        ]);
        if ($this->Schools->delete($school)) {
            $this->Flash->success(__('De school is verwijderd.'));
        } else {
            $this->Flash->error(__('De school kon niet verwijderd worden.  Probeer het nogmaals.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function deleteproject($id)
    {
        $success = false;
        if($this->request->is('DELETE')) {
            $project = $this->Schools->Projects->get($id);

            if(!empty($project)) {
                if($this->Schools->Projects->delete($project)) {
                   $success = true;
                }
            }
            $this->set('project', $project);
        }
        
        $this->set('success', $success);
        $this->RequestHandler->renderAs($this, 'json');
        $this->response->type('application/json');
        $this->set('_serialize', true);
    }
}
