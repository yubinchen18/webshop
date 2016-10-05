<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CartlinesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CartlinesTable Test Case
 */
class CartlinesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CartlinesTable
     */
    public $Cartlines;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.cartlines',
        'app.carts',
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
        'app.orderlines',
        'app.photex_downloads',
        'app.orderstatuses',
        'app.orders_orderstatuses',
        'app.mailaddresses',
        'app.barcodes',
        'app.photos',
        'app.orders',
        'app.products',
        'app.productoptions',
        'app.productoption_choices',
        'app.products_productoptions',
        'app.cartline_productoptions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Cartlines') ? [] : ['className' => 'App\Model\Table\CartlinesTable'];
        $this->Cartlines = TableRegistry::get('Cartlines', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Cartlines);

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
