<?php
namespace App\Controller\Admin;

use App\Controller\AppController\Admin;
use Cake\Event\Event;
use App\Lib\PDFCardCreator;
use Cake\ORM\TableRegistry;
use Cake\Filesystem\Folder;

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
        $schools = $this->Persons->Groups->Projects->Schools->find('list')->orderAsc('name');
        $projects = [__('Selecteer een school')];
        $groups = [__('Selecteer een project')];
        
        $person = $this->Persons->newEntity();        
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
        $this->set(compact('person', 'groups', 'barcodes', 'schools', 'projects', 'groups'));
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
        if ($this->request->is(['patch', 'post', 'put'])) {
            //when group is changed get the old picture folder path
            if (isset($this->request->data['group_id']) && $person->group->id !== $this->request->data['group_id']) {
                $photos = TableRegistry::get('Photos');
                $oldPath = $photos->getPath($person->barcode->id);
            }
            
            $person = $this->Persons->patchEntity($person, $this->request->data);
            if ($this->Persons->save($person)) {
                $this->Flash->success(__('De persoon is opgeslagen.'));
                
                // move folder to new path
                if (isset($oldPath)) {
                    $newPath = $photos->getPath($person->barcode->id);
                    $picFolder = new Folder($oldPath);
                    $picFolder->move([
                        'to' => $newPath,
                        'mode' => 0777
                    ]);
                }
                
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
    
    /**
     * Create card for person
     *
     * @param type $id
     * @return PDF
     */
    public function createPersonCard($id = null)
    {
        $this->viewBuilder()->layout(false);

        //Load the person data
        $data = $this->Persons->get($id, [
            'contain' => ['Groups.Projects.Schools', 'Addresses', 'Barcodes', 'Users']
        ]);
        new PDFCardCreator($data);
    }
}
