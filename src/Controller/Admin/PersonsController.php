<?php
namespace App\Controller\Admin;

use App\Controller\AppController\Admin;
use Cake\Event\Event;

/**
 * Persons Controller
 *
 * @property \App\Model\Table\PersonsTable $Persons
 */
class PersonsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Groups']
        ];
        $persons = $this->paginate($this->Persons);
        $this->set(compact('persons'));
    }

    /**
     * View method
     *
     * @param string|null $id Person id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $person = $this->Persons->get($id, [
            'contain' => ['Groups.Projects', 'Groups.Barcodes', 'Addresses', 'Barcodes', 'Users']
        ]);
        $this->set('person', $person);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $person = $this->Persons->newEntity();
        $groups = $this->Persons->Groups->find('list');
        $barcodes = $this->Persons->Barcodes->find('list');
        if ($this->request->is('post')) {
            if (!empty($this->request->data['user']['password'])) {
                $this->request->data['user']['genuine'] = $this->request->data['user']['password'];
            }

            $person = $this->Persons->patchEntity($person, $this->request->data);
            if ($this->Persons->save($person)) {
                $this->Flash->success(__('De persoon is opgeslagen.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('De persoon kon niet opgeslagen worden. Probeer het nogmaals.'));
            }
        }
        $this->set(compact('person', 'groups', 'barcodes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Person id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $person = $this->Persons->get($id, [
            'contain' => ['Groups', 'Addresses', 'Barcodes', 'Users']
        ]);
        $groups = $this->Persons->Groups->find('list');
        $barcodes = $this->Persons->Barcodes->find('list');
        if ($this->request->is(['patch', 'post', 'put'])) {
            if (isset($this->request->data['differentmail']) && $this->request->data['differentmail'] == 0) {
                $this->Persons->Mailaddresses->delete($person->mailaddress);
                $person->mailladdress = null;
            }
            
            $person = $this->Persons->patchEntity($person, $this->request->data);
            if ($this->Persons->save($person)) {
                $this->Flash->success(__('De persoon is opgeslagen.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('De persoon kon niet opgeslagen worden. Probeer het nogmaals.'));
            }
        }
        $this->set(compact('person', 'groups', 'barcodes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Person id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $person = $this->Persons->get($id);
        if ($this->Persons->delete($person)) {
            $this->Flash->success(__('De persoon is verwijderd.'));
        } else {
            $this->Flash->error(__('De persoon kon niet verwijderd worden.  Probeer het nogmaals.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
