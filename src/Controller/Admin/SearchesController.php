<?php
namespace App\Controller\Admin;

use App\Controller\AppController\Admin;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\ORM\Query;
use Cake\Core\Configure;

/**
 * Searches Controller
 *
 * @property \App\Model\Table\SearchesTable $Searches
 */
class SearchesController extends AppController
{

    /**
     * Show results
     */
    public function showResults()
    {
        $searchTerm = $this->request->query('query');
        
        $schoolsTable = TableRegistry::get('Schools');
        $projectsTable = TableRegistry::get('Projects');
        $groupsTable = TableRegistry::get('Groups');
        $personsTable = TableRegistry::get('Persons');
        $addressesTable = TableRegistry::get('Addresses');
        $ordersTable = TableRegistry::get('Orders');
        
        $schools = $schoolsTable->find()

                ->where(['name LIKE' => "%$searchTerm%"])
                ->contain(['Contacts', 'Visitaddresses'])
                ->all();
        
        $projects = $projectsTable->find()
                ->where(['Projects.name LIKE' => "%$searchTerm%"])
                ->contain('Schools')
                ->all();
        
        $groups = $groupsTable->find()
                ->where(['Groups.name LIKE' => "%$searchTerm%"])
                ->contain('Projects.Schools')
                ->all();
        
        $persons = $personsTable->find()
                ->where(['Persons.lastname LIKE' => "%$searchTerm%"])
                ->contain('Groups.Projects.Schools')
                ->all();
        
        $addresses = $addressesTable->find()
                ->join([
                    'Deliveryorders' => [
                        'table' => 'orders',
                        'type' => 'LEFT',
                        'conditions' => 'Deliveryorders.deliveryaddress_id = Addresses.id'
                    ],
                    'Invoiceorders' => [
                        'table' => 'orders',
                        'type' => 'LEFT',
                        'conditions' => 'Invoiceorders.invoiceaddress_id = Addresses.id'
                    ]                    
                ])
                ->where(['Deliveryorders.ident LIKE' => "%$searchTerm%"])
                ->orWhere(['Invoiceorders.ident LIKE' => "%$searchTerm%"])
                ->orWhere(['Addresses.lastname LIKE' => "%$searchTerm%"])
                ->orWhere(['Addresses.zipcode LIKE' => "%$searchTerm%"])
                ->contain(['Deliveryorders', 'Invoiceorders'])
                ->all();
        
        $this->set(compact('searchTerm', 'schools', 'projects', 'groups', 'persons', 'addresses'));
    }
    
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $searches = $this->paginate($this->Searches);

        $this->set(compact('searches'));
        $this->set('_serialize', ['searches']);
    }

    /**
     * View method
     *
     * @param string|null $id Search id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $search = $this->Searches->get($id, [
            'contain' => []
        ]);

        $this->set('search', $search);
        $this->set('_serialize', ['search']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $search = $this->Searches->newEntity();
        if ($this->request->is('post')) {
            $search = $this->Searches->patchEntity($search, $this->request->data);
            if ($this->Searches->save($search)) {
                $this->Flash->success(__('The search has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The search could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('search'));
        $this->set('_serialize', ['search']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Search id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $search = $this->Searches->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $search = $this->Searches->patchEntity($search, $this->request->data);
            if ($this->Searches->save($search)) {
                $this->Flash->success(__('The search has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The search could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('search'));
        $this->set('_serialize', ['search']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Search id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $search = $this->Searches->get($id);
        if ($this->Searches->delete($search)) {
            $this->Flash->success(__('The search has been deleted.'));
        } else {
            $this->Flash->error(__('The search could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
