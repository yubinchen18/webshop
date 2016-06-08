<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PersonsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PersonsTable Test Case
 */
class PersonsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PersonsTable
     */
    public $Persons;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.persons',
        'app.groups',
        'app.projects',
        'app.schools',
        'app.contacts',
        'app.addresses',
        'app.barcodes',
        'app.users'
    ];

    /*
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Persons') ? [] : ['className' => 'App\Model\Table\PersonsTable'];
        $this->Persons = TableRegistry::get('Persons', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Persons);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $mock = new \Cake\Validation\Validator();
        $validator = $this->Persons->validationDefault($mock);
        $this->assertEquals($mock, $validator);
    }
}
