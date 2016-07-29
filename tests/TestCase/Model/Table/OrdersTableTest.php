<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrdersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrdersTable Test Case
 */
class OrdersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OrdersTable
     */
    public $Orders;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.orders'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Orders') ? [] : ['className' => 'App\Model\Table\OrdersTable'];
        $this->Orders = TableRegistry::get('Orders', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Orders);

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
        $validator = $this->Orders->validationDefault($mock);
        $this->assertEquals($mock, $validator);
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $mock = new \Cake\ORM\RulesChecker();
        $rules = $this->Orders->buildRules($mock);
        $this->assertEquals($mock, $rules);
    }
    
    public function testFindSearchException()
    {
        $this->setExpectedException("\InvalidArgumentException");
        $query = $this->Orders->find('search');
    }
    
    public function testFindSearch()
    {
        $query = $this->Orders->find('search', ['searchTerm' => 'asdf']);
        $this->assertInstanceOf('Cake\ORM\Query', $query);
    }
}
