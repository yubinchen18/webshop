<?php
namespace App\Controller\Admin;

use App\Controller\AppController\Admin;

/**
 * Groups Controller
 *
 * @property \App\Model\Table\GroupsTable $Groups
 */
class CouponsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Persons']
        ];
        $coupons = $this->paginate($this->Coupons);
        $this->set(compact('coupons'));
    }
    
    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $schools = $this->Coupons->Persons->Groups->Projects->Schools->find('list')->orderAsc('name');
        $projects = [];
        $groups = [];
        $persons = [];
        
        $coupon = $this->Coupons->newEntity();
        if ($this->request->is('post')) {
            $coupon = $this->Coupons->patchEntity($coupon, $this->request->data);
            $coupon->coupon_code = $coupon->coupon_code_hidden;
            
            if ($this->Coupons->save($coupon)) {
                $this->Flash->success(__('De coupon is opgeslagen.'));
                return $this->redirect(['action' => 'index']);
            }
            
            $projects = $this->getProjectsForSchool($this->request->data['school_id']);
            $groups = $this->getGroupsForProject($this->request->data['project_id']);
            $persons = $this->getPersonsForGroup($this->request->data['group_id']);
            
            $this->Flash->error(__('De coupon kon niet opgeslagen worden. Probeer het nogmaals.'));
        }
        $this->set(compact('coupon', 'schools', 'projects', 'groups', 'persons'));
    }
    
    /**
     * edit method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function edit($id)
    {
        $coupon = $this->Coupons->get($id, [
            'contain' => ['Persons.Groups.Projects.Schools']
        ]);
        $coupon->school_id = $coupon->person->group->project->school->id;
        $coupon->project_id = $coupon->person->group->project->id;
        $coupon->group_id = $coupon->person->group->id;
        $coupon->coupon_code_hidden = $coupon->coupon_code;
        
        $schools = $this->Coupons->Persons->Groups->Projects->Schools->find('list')->orderAsc('name');
        $projects = $this->getProjectsForSchool($coupon->school_id);
        $groups = $this->getGroupsForProject($coupon->project_id);
        $persons = $this->getPersonsForGroup($coupon->group_id);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $coupon = $this->Coupons->patchEntity($coupon, $this->request->data);
            $coupon->coupon_code = $coupon->coupon_code_hidden;
            
            if ($this->Coupons->save($coupon)) {
                $this->Flash->success(__('De coupon is opgeslagen.'));
                return $this->redirect(['action' => 'index']);
            }
            
            $projects = $this->getProjectsForSchool($this->request->data['school_id']);
            $groups = $this->getGroupsForProject($this->request->data['project_id']);
            $persons = $this->getPersonsForGroup($this->request->data['group_id']);
            
            $this->Flash->error(__('De coupon kon niet opgeslagen worden. Probeer het nogmaals.'));
        }
        $this->set(compact('coupon', 'schools', 'projects', 'groups', 'persons'));
    }
    
    /**
     * Delete method
     *
     * @param string|null $id coupon id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $coupon = $this->Coupons->get($id);
        if ($this->Coupons->delete($coupon)) {
            $this->Flash->success(__('De coupon is verwijderd.'));
        } else {
            $this->Flash->error(__('De coupon kon niet verwijderd worden.  Probeer het nogmaals.'));
        }
        
        return $this->redirect(['action' => 'index']);
    }
    
    public function generateCouponCode()
    {
        $this->render(false);
        
        $keys = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'j', 'k', 'm', 'n', 'p',
            'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 1, 2, 3, 4, 5, 6, 7, 8, 9);
        
        $couponCode = '';
        for ($i = 0; $i < 8; $i++) {
            $couponCode .= $keys[rand(0, count($keys) - 1)];
        }
        
        echo json_encode(array('coupon_code' => strtoupper($couponCode)));
    }
    
    private function getProjectsForSchool($school_id)
    {
        return $this->Coupons->Persons->Groups->Projects->find('list')
            ->where(['Projects.school_id' => $school_id])
            ->orderAsc('Projects.name');
    }
    
    private function getGroupsForProject($project_id)
    {
        return $this->Coupons->Persons->Groups->find('list')
            ->where(['Groups.project_id' => $project_id])
            ->orderAsc('Groups.name');
    }
    
    private function getPersonsForGroup($group_id)
    {
        $persons = $this->Coupons->Persons->find('all')
            ->select(['id', 'firstname', 'prefix', 'lastname'])
            ->where(['group_id' => $group_id])
            ->orderAsc('firstname');
        
        $fixedPersons = [];
        foreach ($persons as $person) {
            $fixedPersons[$person['id']] = $person->firstname.' '.$person->prefix.' '.$person->lastname;
        }
        
        return $fixedPersons;
    }
}
?>