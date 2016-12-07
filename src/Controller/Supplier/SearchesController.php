<?php
namespace App\Controller\Supplier;

use App\Controller\AppController\Supplier;
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
        
        if ($searchTerm) {
            $orders = $schoolsTable->Projects->Groups->Persons->Addresses->Users->Orders
                    ->find('searchForPhotex', compact('searchTerm'))->toArray();
        } else {
            $this->Flash->error(__('Voer een geldige zoekterm in.'));
        }
        $this->set(compact('searchTerm', 'orders'));
    }
}
