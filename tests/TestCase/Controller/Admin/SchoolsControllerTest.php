<?php
namespace App\Test\TestCase\Controller\Admin;

use App\Controller\Admin\SchoolsController;
use App\Test\TestCase\BaseIntegrationTestCase;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\SchoolsController Test Case
 */
class SchoolsControllerTest extends BaseIntegrationTestCase
{
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.schools',
        'app.barcodes',
        'app.addresses',
        'app.contacts',
        'app.projects',
        'app.groups',
        'app.users',
        'app.persons',
        'app.downloadqueues'
    ];

    public function setUp()
    {
        parent::setUp();
        $this->loginAdmin();
        $this->Schools = TableRegistry::get('Schools');
    }

    public function testIndex()
    {
        $this->get('/admin/schools');
        $this->assertResponseOk();
        $schools = $this->viewVariable('schools');
        $this->assertEquals(2, $schools->count());
    }

    public function testView()
    {
        $this->get('/admin/schools/view/82199cab-fc52-4853-8f64-575a7721b8e7');
        $this->assertResponseOk();
        $school = $this->viewVariable('school');
        $this->assertEquals('82199cab-fc52-4853-8f64-575a7721b8e7', $school->id);
        $this->assertEquals('8888b43c-68aa-4845-b7d6-6f50f6f7cece', $school->mailaddress->id);
        $this->assertEquals('9e953dd7-fbac-4dc4-9fec-3ca9cd55397e', $school->visitaddress->id);
        $this->assertEquals('b552c2c1-3d94-4734-b974-c15d5e35fe7c', $school->contact->id);
    }

    public function testAddGet()
    {
        $this->get('/admin/schools/add');
        $this->assertResponseOk();

        $this->assertInstanceOf('App\Model\Entity\School', $this->viewVariable('school'));
    }

    public function testAdd()
    {
        $data = [
            'name' => 'Curran Charles',
            'contact' => [
                'first_name' => 'Walter',
                'prefix' => 'de',
                'last_name' => 'vries',
                'phone' => '+342-67-8288755',
                'fax' => '+732-97-5948863',
                'email' => 'test@test.com',
                'gender' => 'f'
            ],
            'visitaddress' => [
                'street' => 'test',
                'number' => 20,
                'extension' => '',
                'zipcode' => '13933',
                'city' => 'Bernisse',
                'firstname' => 'Erin',
                'prefix' => 'de',
                'lastname' => 'Black',
                'gender' => 'f'
            ],
            'mailaddress' => [
                'street' => 'straatje',
                'number' => 46,
                'extension' => '',
                'zipcode' => 74773,
                'city' => 'Breda',
                'firstname' => 'Delilah',
                'prefix' => '',
                'lastname' => 'Trevino',
                'gender' => 'm'
            ],
            'differentmail' => 1
        ];
        $this->post('/admin/schools/add', $data);
        $this->assertRedirect('/admin/schools');

        $school = $this->Schools->find()->where(['name' => 'Curran Charles'])->first();
        $this->assertNotEmpty($school);
        $this->assertUuid($school->id);
    }

    public function testAddWithoutMailAddress()
    {
        $data = [
            'name' => 'Curran Charles',
            'contact' => [
                'first_name' => 'Walter',
                'prefix' => 'de',
                'last_name' => 'vries',
                'phone' => '+342-67-8288755',
                'fax' => '+732-97-5948863',
                'email' => 'test@test.com',
                'gender' => 'f'
            ],
            'visitaddress' => [
                'street' => 'test',
                'number' => 20,
                'extension' => '',
                'zipcode' => '13933',
                'city' => 'Bernisse',
                'firstname' => 'Erin',
                'prefix' => 'de',
                'lastname' => 'Black',
                'gender' => 'f'
            ],
            'differentmail' => 1
        ];
        $this->post('/admin/schools/add', $data);
        $this->assertRedirect('/admin/schools');

        $school = $this->Schools->find()->where(['name' => 'Curran Charles'])->first();
        $this->assertNotEmpty($school);
        $this->assertUuid($school->id);
    }

    public function testAddFailure()
    {
        $data = [
            'name' => '',
            'contact' => [
                'first_name' => 'Walter',
                'prefix' => 'de',
                'last_name' => 'vries',
                'phone' => '+342-67-8288755',
                'fax' => '+732-97-5948863',
                'email' => 'test@test.com',
                'gender' => 'f'
            ],
            'visitaddress' => [
                'street' => 'test',
                'number' => 20,
                'extension' => '',
                'zipcode' => '13933',
                'city' => 'Bernisse',
                'firstname' => 'Erin',
                'prefix' => 'de',
                'lastname' => 'Black',
                'gender' => 'f'
            ],
            'mailaddress' => [
                'street' => 'straatje',
                'number' => 46,
                'extension' => '',
                'zipcode' => 74773,
                'city' => 'Breda',
                'firstname' => 'Delilah',
                'prefix' => '',
                'lastname' => 'Trevino',
                'gender' => 'm'
            ],
            'differentmail' => 1
        ];
        $this->post('/admin/schools/add', $data);
        $this->assertResponseOk();

        $this->assertInstanceOf('App\Model\Entity\School', $this->viewVariable('school'));
        $errors = [
            'name' => [
                '_empty' => 'This field cannot be left empty'
            ]
        ];
        $this->assertEquals($errors, $this->viewVariable('school')->errors());
    }

    public function testEditGet()
    {
        $this->get('/admin/schools/edit/82199cab-fc52-4853-8f64-575a7721b8e7');

        $this->assertResponseOk();

        $school = $this->viewVariable('school');

        $this->assertEquals('82199cab-fc52-4853-8f64-575a7721b8e7', $school->id);
    }

    public function testEdit()
    {
        $id = '82199cab-fc52-4853-8f64-575a7721b8e7';
        $data = [
            'name' => 'changedschool',

        ];
        $this->put('/admin/schools/edit/'.$id, $data);
        $this->assertRedirect('/admin/schools');

        $school = $this->Schools->find()->where(['id' => $id])->first();
        $this->assertNotEmpty($school);
        $this->assertEquals($data['name'], $school->name);
    }

    public function testEditNoPost()
    {
        $id = '82199cab-fc52-4853-8f64-575a7721b8e7';
        $data = [
            'name' => 'changedschool',
            'differentmail' => 0

        ];
        $this->put('/admin/schools/edit/'.$id, $data);
        $this->assertRedirect('/admin/schools');

        $school = $this->Schools->find()->where(['id' => $id])->first();
        $this->assertNotEmpty($school);
        $this->assertEmpty($school->mailaddress);
        $this->assertEquals($data['name'], $school->name);
    }

    public function testDelete()
    {
        $id = '82199cab-fc52-4853-8f64-575a7721b8e7';
        $school = $this->Schools->find()->where(['id' => $id])->first();
        $this->assertNotEmpty($school);
        $this->delete('/admin/schools/delete/'.$id);
        $this->assertRedirect('/admin/schools');
        $school = $this->Schools->find()->where(['id' => $id])->first();
        $this->assertEmpty($school);
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
            'name' => '',
            'contact' => [
                'first_name' => 'Walter',
                'prefix' => 'de',
                'last_name' => 'vries',
                'phone' => '+342-67-8288755',
                'fax' => '+732-97-5948863',
                'email' => 'test@test.com',
                'gender' => 'f'
            ],
            'visitaddress' => [
                'street' => 'test',
                'number' => 20,
                'extension' => '',
                'zipcode' => '13933',
                'city' => 'Bernisse',
                'firstname' => 'Erin',
                'prefix' => 'de',
                'lastname' => 'Black',
                'gender' => 'f'
            ],
            'mailaddress' => [
                'street' => 'straatje',
                'number' => 46,
                'extension' => '',
                'zipcode' => 74773,
                'city' => 'Breda',
                'firstname' => 'Delilah',
                'prefix' => '',
                'lastname' => 'Trevino',
                'gender' => 'm'
            ],
            'differentmail' => 1,
            'projects' => [
                [
                    'school_id' => '82199cab-fc52-4853-8f64-575a7721b8e7',
                    'id' => '4a7d8a96-08f6-441c-a8d5-eb40440e7603',
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
            ]
        ];

        $id = '82199cab-fc52-4853-8f64-575a7721b8e7';

        $addressesPrecount = $this->Addresses->find()->count();
        $barcodesPrecount = $this->Barcodes->find()->count();
        $usersPrecount = $this->Users->find()->count();
        $groupsPrecount = $this->Groups->find()->count();
        $personsPrecount = $this->Persons->find()->count();

        $this->put('/admin/schools/edit/'.$id, $data);

        $addressesCount = $this->Addresses->find()->count();
        $barcodesCount = $this->Barcodes->find()->count();
        $usersCount = $this->Users->find()->count();
        $groupsCount = $this->Groups->find()->count();
        $personsCount = $this->Persons->find()->count();
//debug( $this->Barcodes->find()->toArray());
        $this->assertEquals(1 ,($addressesCount - $addressesPrecount)); //2
        $this->assertEquals(3 ,($barcodesCount - $barcodesPrecount)); //3
        $this->assertEquals(2 ,($usersCount - $usersPrecount)); //2
        $this->assertEquals(1 ,($groupsCount - $groupsPrecount)); //1
        $this->assertEquals(2 ,($personsCount - $personsPrecount)); //2
    }
}
