<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrderstatusesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrderstatusesTable Test Case
 */
class OrderstatusesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OrderstatusesTable
     */
    public $Orderstatuses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.orderstatuses',
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
        'app.orders_orderstatuses',
        'app.mailaddresses'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Orderstatuses') ? [] : ['className' => 'App\Model\Table\OrderstatusesTable'];
        $this->Orderstatuses = TableRegistry::get('Orderstatuses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Orderstatuses);

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
}
