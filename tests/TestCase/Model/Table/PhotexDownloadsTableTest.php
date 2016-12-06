<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PhotexDownloadsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PhotexDownloadsTable Test Case
 */
class PhotexDownloadsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PhotexDownloadsTable
     */
    public $PhotexDownloads;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.photex_downloads',
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
        'app.carts',
        'app.cartlines',
        'app.photos',
        'app.barcodes',
        'app.products',
        'app.orderlines',
        'app.orderline_productoptions',
        'app.productoption_choices',
        'app.productoptions',
        'app.products_productoptions',
        'app.cartline_productoptions',
        'app.orders_orderstatuses',
        'app.orderstatuses',
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
        $config = TableRegistry::exists('PhotexDownloads') ? [] : ['className' => 'App\Model\Table\PhotexDownloadsTable'];
        $this->PhotexDownloads = TableRegistry::get('PhotexDownloads', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PhotexDownloads);

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
