<?php
namespace App\Test\TestCase\Controller\Admin;

use App\Controller\Admin\ProjectsController;
use App\Test\TestCase\BaseIntegrationTestCase;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\ProjectsController Test Case
 */
class ProjectsControllerTest extends BaseIntegrationTestCase
{
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.addresses',
        'app.barcodes',
        'app.carts',
        'app.cartlines',
        'app.contacts',
        'app.downloadqueues',
        'app.groups',
        'app.persons',
        'app.photos',
        'app.products',
        'app.projects',
        'app.schools',
        'app.users',
    ];

    public function setUp()
    {
        parent::setUp();
        $this->loginAdmin();
        $this->Projects = TableRegistry::get('Projects');
    }

    public function testIndex()
    {
        $this->get('/admin/projects');
        $this->assertResponseOk();
        $projects = $this->viewVariable('projects');
        $this->assertEquals(1, $projects->count());
    }

    public function testView()
    {
        $this->get('/admin/projects/view/4a7d8a96-08f6-441c-a8d5-eb40440e7603');
        $this->assertResponseOk();
        $project = $this->viewVariable('project');
        $this->assertEquals('4a7d8a96-08f6-441c-a8d5-eb40440e7603', $project->id);
        $this->assertEquals('82199cab-fc52-4853-8f64-575a7721b8e7', $project->school->id);
    }

    public function testAddGet()
    {
        $this->get('/admin/projects/add');
        $this->assertResponseOk();

        $this->assertInstanceOf('App\Model\Entity\Project', $this->viewVariable('project'));
    }

    public function testAdd()
    {
        $data = [
            'name' => 'New project',
            'slug' => 'new-project',
            'school_id' => '82199cab-fc52-4853-8f64-575a7721b8e7',
            'grouptext' => 'groepstekst'
        ];
        $this->post('/admin/projects/add', $data);
        $this->assertRedirect();

        $project = $this->Projects->find()->where(['name' => 'New project'])->first();
        $this->assertNotEmpty($project);
        $this->assertUuid($project->id);
    }

    public function testAddFailure()
    {
        $data = [
            'name' => '',
            'slug' => 'new-project',
            'school_id' => '82199cab-fc52-4853-8f64-575a7721b8e7',
            'grouptext' => 'groepstekst'
        ];
        $this->post('/admin/projects/add', $data);
        $this->assertResponseOk();

        $this->assertInstanceOf('App\Model\Entity\Project', $this->viewVariable('project'));
        $errors = [
            'name' => [
                '_empty' => 'This field cannot be left empty'
            ]
        ];
        $this->assertEquals($errors, $this->viewVariable('project')->errors());
    }

    public function testEditGet()
    {
        $this->get('/admin/projects/edit/4a7d8a96-08f6-441c-a8d5-eb40440e7603');

        $this->assertResponseOk();

        $project = $this->viewVariable('project');

        $this->assertEquals('4a7d8a96-08f6-441c-a8d5-eb40440e7603', $project->id);
    }

    public function testEdit()
    {
        $id = '4a7d8a96-08f6-441c-a8d5-eb40440e7603';
        $data = [
            'name' => 'changedproject',
        ];
        $this->put('/admin/projects/edit/'.$id, $data);
        $this->assertRedirect();

        $project = $this->Projects->find()->where(['id' => $id])->first();
        $this->assertNotEmpty($project);
        $this->assertEquals($data['name'], $project->name);
    }

    public function testDelete()
    {
        $id = '4a7d8a96-08f6-441c-a8d5-eb40440e7603';
        $project = $this->Projects->find()->where(['id' => $id])->first();
        $this->assertNotEmpty($project);
        $this->delete('/admin/projects/delete/'.$id);
        $this->assertRedirect('/admin/projects');
        $project = $this->Projects->find()->where(['id' => $id])->first();
        $this->assertEmpty($project);
    }
    
    public function testUploadCsv()
    {
        $this->Addresses = TableRegistry::get('Addresses');
        $this->Barcodes = TableRegistry::get('Barcodes');
        $this->Users = TableRegistry::get('Users');
        $this->Groups = TableRegistry::get('Groups');
        $this->Persons = TableRegistry::get('Persons');

        $filename = TESTS . 'Fixture' .  DS . 'group-import.xlsx';
        $data = [
            'project' => [
                'id' => '4a7d8a96-08f6-441c-a8d5-eb40440e7603',
                'school_id' => '82199cab-fc52-4853-8f64-575a7721b8e7',
                'name' => 'test',
                'slug' => 'test',
                'grouptext' => 'tes groepstekst',
                'file' => [
                    'name' => 'hoogstraten-group.xlsx',
                    'type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'tmp_name' => $filename,
                    'error' => '0',
                    'size' => '4842'
                ]
            ]
        ];

        $addressesPrecount = $this->Addresses->find()->count();
        $barcodesPrecount = $this->Barcodes->find()->count();
        $usersPrecount = $this->Users->find()->count();
        $groupsPrecount = $this->Groups->find()->count();
        $personsPrecount = $this->Persons->find()->count();

        $this->put('/admin/projects/edit/4a7d8a96-08f6-441c-a8d5-eb40440e7603', $data);

        $addressesCount = $this->Addresses->find()->count();
        $barcodesCount = $this->Barcodes->find()->count();
        $usersCount = $this->Users->find()->count();
        $groupsCount = $this->Groups->find()->count();
        $personsCount = $this->Persons->find()->count();


        $this->assertEquals(2, ($addressesCount - $addressesPrecount)); //2
        $this->assertEquals(8, ($barcodesCount - $barcodesPrecount)); //4 students, 2 docents, 2 groups
        $this->assertEquals(6, ($usersCount - $usersPrecount)); //2
        $this->assertEquals(2, ($groupsCount - $groupsPrecount)); //1
        $this->assertEquals(6, ($personsCount - $personsPrecount)); //2
    }
    
    public function testSchoolProjects()
    {
        $school_id = '82199cab-fc52-4853-8f64-575a7721b8e7';
        $this->get('/admin/projects/'. $school_id . '.json');
         
        $this->assertResponseContains('Eindejaars 2016');
    }
}
