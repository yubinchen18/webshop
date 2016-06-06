<?php
namespace App\Test\TestCase\Controller\Admin;

use App\Controller\Admin\PersonsController;
use App\Test\TestCase\BaseIntegrationTestCase;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\PersonsController Test Case
 */
class PersonsControllerTest extends BaseIntegrationTestCase
{
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
    ];

    public function setUp()
    {
        parent::setUp();
        $this->loginAdmin();
        $this->Persons = TableRegistry::get('Persons');
    }

    public function testIndex()
    {
        $this->get('/admin/persons');
        $this->assertResponseOk();
        $persons = $this->viewVariable('persons');
        $this->assertEquals(2, $persons->count());
    }

    public function testView()
    {
        $this->get('/admin/persons/view/1447e1dd-f3a5-4183-9508-725519b3107d');
        $this->assertResponseOk();
        $person = $this->viewVariable('person');
        $this->assertEquals('1447e1dd-f3a5-4183-9508-725519b3107d', $person->id);
        $this->assertEquals('e5b778cd-68cd-469f-88b3-37846b984868', $person->group->id);
        $this->assertEquals('9e953dd7-fbac-4dc4-9fec-3ca9cd55397e', $person->address->id);
        $this->assertEquals('c78338d8-b286-4b9e-8486-6bd3de3be695', $person->barcode->id);
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
