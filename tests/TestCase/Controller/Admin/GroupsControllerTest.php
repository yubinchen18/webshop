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
    ];

    public function setUp()
    {
        parent::setUp();
        $this->loginAdmin();
        $this->Groups = TableRegistry::get('Groups');
    }

    public function testIndex()
    {
        $this->get('/admin/groups');
        $this->assertResponseOk();
        $groups = $this->viewVariable('groups');
        $this->assertEquals(2, $groups->count());
    }

    public function testView()
    {
        $this->get('/admin/groups/view/e5b778cd-68cd-469f-88b3-37846b984868');
        $this->assertResponseOk();
        $group = $this->viewVariable('group');
        $this->assertEquals('e5b778cd-68cd-469f-88b3-37846b984868', $group->id);
        $this->assertEquals('4a7d8a96-08f6-441c-a8d5-eb40440e7603', $group->project->id);
        $this->assertEquals('c78338d8-b286-4b9e-8486-6bd3de3be695', $group->barcode->id);
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
            'barcode_id' => 'c78338d8-b286-4b9e-8486-6bd3de3be695'
        ];
        $this->post('/admin/groups/add', $data);
        $this->assertRedirect('/admin/groups');

        $group = $this->Groups->find()->where(['name' => 'Nieuwe Klas'])->first();
        $this->assertNotEmpty($group);
        $this->assertUuid($group->id);
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
        $id = 'e5b778cd-68cd-469f-88b3-37846b984868';
        $data = [
            'name' => 'changedgroup',

        ];
        $this->put('/admin/groups/edit/'.$id, $data);
        $this->assertRedirect('/admin/groups');

        $group = $this->Groups->find()->where(['id' => $id])->first();
        $this->assertNotEmpty($group);
        $this->assertEquals($data['name'], $group->name);
    }

    public function testDelete()
    {
        $id = 'e5b778cd-68cd-469f-88b3-37846b984868';
        $group = $this->Groups->find()->where(['id' => $id])->first();
        $this->assertNotEmpty($group);
        $this->delete('/admin/groups/delete/'.$id);
        $this->assertRedirect('/admin/groups');
        $group = $this->Groups->find()->where(['id' => $id])->first();
        $this->assertEmpty($group);
    }
}
