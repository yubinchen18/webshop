<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrderlineProductoptionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrderlineProductoptionsTable Test Case
 */
class OrderlineProductoptionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OrderlineProductoptionsTable
     */
    public $OrderlineProductoptions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.orderline_productoptions',
        'app.orderlines',
        'app.orders',
        'app.users',
        'app.addresses',
        'app.invoices',
        'app.persons',
        'app.groups',
        'app.projects',
        'app.schools',
        'app.contacts',
        'app.visitaddresses',
        'app.deliveryorders',
        'app.deliveryaddresses',
        'app.invoiceorders',
        'app.invoiceaddresses',
        'app.trxes',
        'app.photex_downloads',
        'app.orderstatuses',
        'app.orders_orderstatuses',
        'app.mailaddresses',
        'app.barcodes',
        'app.photos',
        'app.carts',
        'app.cartlines',
        'app.products',
        'app.productoptions',
        'app.productoption_choices',
        'app.cartline_productoptions',
        'app.products_productoptions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('OrderlineProductoptions') ? [] : ['className' => 'App\Model\Table\OrderlineProductoptionsTable'];
        $this->OrderlineProductoptions = TableRegistry::get('OrderlineProductoptions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OrderlineProductoptions);

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
