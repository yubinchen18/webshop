<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AddressesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AddressesTable Test Case
 */
class AddressesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AddressesTable
     */
    public $Addresses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.addresses',
        'app.users',
    ];

    /*
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Addresses') ? [] : ['className' => 'App\Model\Table\AddressesTable'];
        $this->Addresses = TableRegistry::get('Addresses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Addresses);

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
        $validator = $this->Addresses->validationDefault($mock);
        $this->assertEquals($mock, $validator);
    }
}
