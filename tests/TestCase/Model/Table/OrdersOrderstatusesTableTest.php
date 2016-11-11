<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrdersOrderstatusesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrdersOrderstatusesTable Test Case
 */
class OrdersOrderstatusesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OrdersOrderstatusesTable
     */
    public $OrdersOrderstatuses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.orders_orderstatuses',
        'app.orders',
        'app.users',
        'app.addresses',
        'app.invoices',
        'app.persons',
        'app.groups',
        'app.projects',
        'app.schools',
        'app.contacts',
        'app.orderlines',
        'app.photos',
        'app.barcodes',
        'app.products',
        'app.cartlines',
        'app.carts',
        'app.cartline_productoptions',
        'app.productoption_choices',
        'app.productoptions',
        'app.products_productoptions',
        'app.orderline_productoptions',
        'app.photex_downloads',
        'app.orderstatuses',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('OrdersOrderstatuses') ? [] : ['className' => 'App\Model\Table\OrdersOrderstatusesTable'];
        $this->OrdersOrderstatuses = TableRegistry::get('OrdersOrderstatuses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OrdersOrderstatuses);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
