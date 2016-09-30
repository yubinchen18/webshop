<?php
namespace App\Test\TestCase\Controller\Admin;

use App\Controller\Admin\PersonsController;
use App\Test\TestCase\BaseIntegrationTestCase;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;
use org\bovigo\vfs\vfsStream;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;

/**
 * App\Controller\PersonsController Test Case
 */
class PersonsControllerTest extends BaseIntegrationTestCase
{
    private $vfsStream;
    private $vfsRoot;
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.users',
        'app.persons',
        'app.addresses',
        'app.contacts',
        'app.groups',
        'app.barcodes',
        'app.projects',
        'app.photos',
        'app.schools',
    ];

    public function setUp()
    {
        parent::setUp();
        $this->loginAdmin();
        $this->Persons = TableRegistry::get('Persons');
        $this->Photos = TableRegistry::get('Photos');
        $this->vfsStream = vfsStream::setup('data', null, ['tmp' => []]);
        $this->vfsRoot = 'vfs://data';
        $this->Photos->baseDir = $this->vfsRoot;
    }
    
    public function tearDown()
    {
        unset($this->vfsStream);
        unset($this->Photos);
        parent::tearDown();
    }

    public function testIndex()
    {
        $this->get('/admin/persons');
        $this->assertResponseOk();
        $persons = $this->viewVariable('persons');
        $this->assertEquals(3, $persons->count());
    }

    public function testView()
    {
        $this->get('/admin/persons/view/1447e1dd-f3a5-4183-9508-725519b3107d');
        $this->assertResponseOk();
        $person = $this->viewVariable('person');
        $this->assertEquals('1447e1dd-f3a5-4183-9508-725519b3107d', $person->id);
        $this->assertEquals('e5b778cd-68cd-469f-88b3-37846b984868', $person->group->id);
        $this->assertEquals('9e953dd7-fbac-4dc4-9fec-3ca9cd55397e', $person->address->id);
        $this->assertEquals('df99d62f-258c-424d-a1fe-af3213e70867', $person->barcode->id);
        $this->assertEquals('91017bf5-5b19-438b-bd44-b0c4e1eaf903', $person->user->id);
    }

    public function testAddGet()
    {
        $this->get('/admin/persons/add');
        $this->assertResponseOk();

        $this->assertInstanceOf('App\Model\Entity\Person', $this->viewVariable('person'));
    }

    public function testAdd()
    {
        $data = [
            'studentnumber' => '1234567444489',
            'firstname' => 'Pieter',
            'prefix' => '',
            'lastname' => 'Vos',
            'slug' => 'pieter-vos',
            'email' => 'test@testworld.nl',
            'type' => 'leerling',
            'group_id' => '8262ca6b-f23a-4154-afed-fc893c1516d3',
            'barcode_id' => 'ba0f3313-757a-430a-bda3-908082dea691',
            'user' => [
                'username' => 'leerling01',
                'password' => 'pass#@word',
                'email' => 'test@test.nl',
            ],
            'address' => [
                'street' => 'test',
                'number' => 20,
                'extension' => '',
                'zipcode' => '13933',
                'city' => 'Bernisse',
                'firstname' => 'Erin',
                'prefix' => 'de',
                'lastname' => 'Black',
                'gender' => 'f'
            ]
        ];
        $this->post('/admin/persons/add', $data);
        $this->assertRedirect('/admin/persons');

        $person = $this->Persons->find()->where(['studentnumber' => '1234567444489'])->first();
        $this->assertNotEmpty($person);
        $this->assertUuid($person->id);
    }

    public function testAddFailure()
    {
        $data = [
            'studentnumber' => '',
            'firstname' => 'Pieter',
            'prefix' => '',
            'lastname' => 'Vos',
            'slug' => 'pieter-vos',
            'email' => 'test@testworld.nl',
            'type' => 'leerling',
            'group_id' => '8262ca6b-f23a-4154-afed-fc893c1516d3',
            'barcode_id' => 'c5571a8d-bc26-4c42-ae64-a9fd5fc0c799',
            'user' => [
                'username' => 'leerling01',
                'password' => 'pass#@word',
                'email' => 'test@test.nl',
            ],
            'address' => [
                'street' => 'test',
                'number' => 20,
                'extension' => '',
                'zipcode' => '13933',
                'city' => 'Bernisse',
                'firstname' => 'Erin',
                'prefix' => 'de',
                'lastname' => 'Black',
                'gender' => 'f'
            ]
        ];
        $this->post('/admin/persons/add', $data);
        $this->assertResponseOk();

        $this->assertInstanceOf('App\Model\Entity\Person', $this->viewVariable('person'));
        $errors = [
            'studentnumber' => [
                '_empty' => 'This field cannot be left empty'
            ]
        ];
        $this->assertEquals($errors, $this->viewVariable('person')->errors());
    }

    public function testEditGet()
    {
        $this->get('/admin/persons/edit/1447e1dd-f3a5-4183-9508-725519b3107d');

        $this->assertResponseOk();

        $person = $this->viewVariable('person');

        $this->assertEquals('1447e1dd-f3a5-4183-9508-725519b3107d', $person->id);
    }

    public function testEdit()
    {
        $id = '1447e1dd-f3a5-4183-9508-725519b3107d';
        $data = [
            'studentnumber' => '00000000',

        ];
        $this->put('/admin/persons/edit/'.$id, $data);
        $this->assertRedirect('/admin/persons');

        $person = $this->Persons->find()->where(['id' => $id])->first();
        $this->assertNotEmpty($person);
        $this->assertEquals($data['studentnumber'], $person->studentnumber);
    }
    
        
    public function testEditGroup()
    {
        $id = '1447e1dd-f3a5-4183-9508-725519b3107d';
        $data = [
            'group_id' => '8262ca6b-f23a-4154-afed-fc893c1516d3',
        ];
        $this->put('/admin/persons/edit/'.$id, $data);
        $this->assertRedirect('/admin/persons');
        $person2 = $this->Persons->find()->where(['id' => $id])->first();
        $this->assertNotEmpty($person2);
        $this->assertEquals($data['group_id'], $person2->group_id);
    }
    
    public function testEditFolder()
    {
        $id = '1447e1dd-f3a5-4183-9508-725519b3107d';
        $data = [
            'group_id' => '8262ca6b-f23a-4154-afed-fc893c1516d3',
        ];
        $this->put('/admin/persons/edit/'.$id, $data);
        $this->assertRedirect('/admin/persons');
        $person = $this->Persons->find()->where(['id' => $id])->first();
        $oldPath = $this->vfsRoot. '/de-ring-van-putten/eindejaars-2016/klas-2a/pieter-vos';
        $newPath = $this->vfsRoot. '/de-ring-van-putten/eindejaars-2016/klas-blauw/pieter-vos';
        $oldFolder = new Folder($oldPath);
        $newFolder = new Folder($newPath);
        
        $this->assertTrue(file_exists($newFolder->pwd()));
        $this->assertFalse(file_exists($oldFolder->pwd()));
    }

    public function testDelete()
    {
        $id = '1447e1dd-f3a5-4183-9508-725519b3107d';
        $person = $this->Persons->find()->where(['id' => $id])->first();
        $this->assertNotEmpty($person);
        $this->delete('/admin/persons/delete/'.$id);
        $this->assertRedirect('/admin/persons');
        $person = $this->Persons->find()->where(['id' => $id])->first();
        $this->assertEmpty($person);
    }
}
