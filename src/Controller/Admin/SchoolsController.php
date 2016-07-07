<?php
namespace App\Controller\Admin;

use App\Controller\AppController\Admin;
use Cake\Event\Event;

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
     * Export method
     * 
     * @return CSV
     */
    public function export()
    {
        $schools = $this->Schools->find('all', ['contain' => ['Contacts', 'Visitaddresses', 'Mailaddresses']])->orderAsc('name');      
        $this->set(compact('schools'));        
        $this->set('_serialize', 'schools');
        $this->set('_csvMap', function ($school) {
            return [
                $school->name,
                $school->contact->phone,
                $school->contact->fax,
                $school->contact->email,
                $school->visitaddress->street,
                $school->visitaddress->city,
                $school->visitaddress->zipcode,
                $school->mailaddress->street,
                $school->mailaddress->city,
                $school->mailaddress->zipcode,
                $school->contact->first_name.' '.$school->contact->last_name               
                ];
            });
        $this->set('_headerCsv', [
            __('Organisatie'),
            __('Telefoonnummer'),
            __('Faxnummer'),
            __('Emailadres'),
            __('Bezoekadres (Straat)'),
            __('Bezoekadres (Plaats)'),
            __('Bezoekadres (Postcode)'),
            __('Postadres (Straat)'),
            __('Postadres (Plaats)'),
            __('Postadres (Postcode)'),
            __('Contactpersoon')
        ]);
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
            'contain' => ['Contacts', 'Visitaddresses', 'Mailaddresses']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            if (isset($this->request->data['differentmail']) && $this->request->data['differentmail'] == 0) {
                $this->Schools->Mailaddresses->delete($school->mailaddress);
                $school->mailladdress = null;
            }
            
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
}
