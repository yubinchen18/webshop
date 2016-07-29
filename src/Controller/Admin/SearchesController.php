<?php
namespace App\Controller\Admin;

use App\Controller\AppController\Admin;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\ORM\Query;

/**
 * Searches Controller
 *
 * @property \App\Model\Table\SearchesTable $Searches
 */
class SearchesController extends AppController
{

    /**
     * Show search results
     */
    public function showResults()
    {
        $searchTerm = trim($this->request->query('query'));
        
        $schoolsTable = TableRegistry::get('Schools');
        $ordersTable = TableRegistry::get('Orders');
        
        if ($searchTerm) {
            $schools = $schoolsTable->find('search', compact('searchTerm'))->toArray();
            $projects = $schoolsTable->Projects->find('search', compact('searchTerm'))->toArray();
            $groups = $schoolsTable->Projects->Groups->find('search', compact('searchTerm'))->toArray();
            $persons = $schoolsTable->Projects->Groups->Persons->find('search', compact('searchTerm'))->toArray();
            $addresses = $schoolsTable->Projects->Groups->Persons->Addresses
                    ->find('search', compact('searchTerm'))->toArray();
            $orders = $schoolsTable->Projects->Groups->Persons->Addresses->Users->Orders
                    ->find('search', compact('searchTerm'))->toArray();
        } else {
            $this->Flash->error(__('Voer een geldige zoekterm in.'));
        }
        $this->set(compact('searchTerm', 'schools', 'projects', 'groups', 'persons', 'addresses', 'orders'));
    }
}
