<?php
namespace App\Test\TestCase\Controller\Admin;

use App\Controller\Admin\GroupsController;
use App\Test\TestCase\BaseIntegrationTestCase;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\GroupsController Test Case
 */
class GroupsControllerTest extends BaseIntegrationTestCase
{
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.groups',
        'app.addresses',
        'app.contacts',
        'app.schools',
        'app.projects',
        'app.barcodes',
        'app.users',
        'app.downloadqueues'
    ];

    public function setUp()
    {
        parent::setUp();
        $this->loginAdmin();
        $this->Groups = TableRegistry::get('Groups');
        $this->Downloadqueues = TableRegistry::get('Downloadqueues');
        $this->Users = TableRegistry::get('Users');
    }

    public function testIndex()
    {
        $this->get('/admin/groups');
        $this->assertResponseOk();
        $groups = $this->viewVariable('groups');
        $this->assertEquals(4, $groups->count());
    }

    public function testView()
    {
        $this->get('/admin/groups/view/e5b778cd-68cd-469f-88b3-37846b984868');
        $this->assertResponseOk();
        $group = $this->viewVariable('group');
        $this->assertEquals('e5b778cd-68cd-469f-88b3-37846b984868', $group->id);
        $this->assertEquals('4a7d8a96-08f6-441c-a8d5-eb40440e7603', $group->project->id);
        $this->assertEquals('0e46688d-02a9-4da4-9f91-ed61a3e7246e', $group->barcode->id);
    }

    public function testAddGet()
    {
        $this->get('/admin/groups/add');
        $this->assertResponseOk();

        $this->assertInstanceOf('App\Model\Entity\Group', $this->viewVariable('group'));
    }

    public function testAdd()
    {
        $data = [
            'name' => 'Nieuwe Klas',
            'slug' => 'nieuwe-klas',
            'project_id' => '4a7d8a96-08f6-441c-a8d5-eb40440e7603',
            'barcode_id' => 'ba0f3313-757a-430a-bda3-908082dea691'
        ];
        // Check number of queued items before add
        $countQueueItems = $this->Downloadqueues->find()->count();
        
        $this->post('/admin/groups/add', $data);
        $this->assertRedirect('/admin/groups');
        
        $group = $this->Groups->find()->where(['name' => 'Nieuwe Klas'])->first();
        $this->assertNotEmpty($group);
        $this->assertUuid($group->id);
        
        // Check if this school has been added to the downloadqueue
        $countPhotographers = $this->Users->find()->where(['Users.type' => 'photographer'])->count();
        $countNewQueue = $this->Downloadqueues->find()->count();
        
        $this->assertEquals($countPhotographers+$countQueueItems, $countNewQueue);
        
    }

    public function testAddFailure()
    {
        $data = [
            'name' => '',
            'slug' => 'nieuwe-klas',
            'project_id' => '4a7d8a96-08f6-441c-a8d5-eb40440e7603',
            'barcode_id' => 'c78338d8-b286-4b9e-8486-6bd3de3be695'
        ];
        $this->post('/admin/groups/add', $data);
        $this->assertResponseOk();

        $this->assertInstanceOf('App\Model\Entity\Group', $this->viewVariable('group'));
        $errors = [
            'name' => [
                '_empty' => 'This field cannot be left empty'
            ]
        ];
        $this->assertEquals($errors, $this->viewVariable('group')->errors());
    }

    public function testEditGet()
    {
        $this->get('/admin/groups/edit/e5b778cd-68cd-469f-88b3-37846b984868');

        $this->assertResponseOk();

        $group = $this->viewVariable('group');

        $this->assertEquals('e5b778cd-68cd-469f-88b3-37846b984868', $group->id);
    }

    public function testEdit()
    {
        $id = '8262ca6b-f23a-4154-afed-fc893c1516d3';
        $data = [
            'name' => 'changedgroup',

        ];
        // Check number of queued items before edit
        $countQueueItems = $this->Downloadqueues->find()->count();
        
        $this->put('/admin/groups/edit/'.$id, $data);
        $this->assertRedirect('/admin/groups');

        $group = $this->Groups->find()->where(['id' => $id])->first();
        $this->assertNotEmpty($group);
        $this->assertEquals($data['name'], $group->name);
        
        // Check if this group has been added to the downloadqueue
        $countPhotographers = $this->Users->find()->where(['Users.type' => 'photographer'])->count();
        $countNewQueue = $this->Downloadqueues->find()->count();
        
        $this->assertEquals($countPhotographers+$countQueueItems, $countNewQueue);
    }

    public function testDelete()
    {
        $id = '8262ca6b-f23a-4154-afed-fc893c1516d3';
        $group = $this->Groups->find()->where(['id' => $id])->first();
        $this->assertNotEmpty($group);
        
        // Check number of queued items before deletion
        $countQueueItems = $this->Downloadqueues->find()->count();        
        
        $this->delete('/admin/groups/delete/'.$id);
        $this->assertRedirect('/admin/groups');
        $group = $this->Groups->find()->where(['id' => $id])->first();
        $this->assertEmpty($group);
        
        // Check if this group has been added to the downloadqueue
        $countPhotographers = $this->Users->find()->where(['Users.type' => 'photographer'])->count();
        $countNewQueue = $this->Downloadqueues->find()->count();
        
        $this->assertEquals($countPhotographers+$countQueueItems, $countNewQueue);
    }
    
    public function testProductgroups()
    {
        $project_id = '4a7d8a96-08f6-441c-a8d5-eb40440e7603';
        $this->get('/admin/groups/'. $project_id . '.json');
         
        $this->assertResponseContains('Klas blauw');
        $response = json_decode($this->_response->body(), true);
        $this->assertEquals(4, count($response['groups']));
    }
}
