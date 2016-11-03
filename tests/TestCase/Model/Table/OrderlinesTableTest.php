<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrderlinesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrderlinesTable Test Case
 */
class OrderlinesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OrderlinesTable
     */
    public $Orderlines;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        'app.photex_downloads',
        'app.orderstatuses',
        'app.orders_orderstatuses',
        'app.barcodes',
        'app.photos',
        'app.carts',
        'app.cartlines',
        'app.products',
        'app.productoptions',
        'app.productoption_choices',
        'app.cartline_productoptions',
        'app.orderline_productoptions',
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
        $config = TableRegistry::exists('Orderlines') ? [] : ['className' => 'App\Model\Table\OrderlinesTable'];
        $this->Orderlines = TableRegistry::get('Orderlines', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Orderlines);

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
