<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CartCouponsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CartCouponsTable Test Case
 */
class CartCouponsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CartCouponsTable
     */
    public $CartCoupons;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.cart_coupons',
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
        'app.orders',
        'app.photex_downloads',
        'app.orders_orderstatuses',
        'app.orderstatuses',
        'app.photos',
        'app.barcodes',
        'app.products',
        'app.cartlines',
        'app.cartline_productoptions',
        'app.productoption_choices',
        'app.productoptions',
        'app.products_productoptions',
        'app.orderline_productoptions',
        'app.mailaddresses',
        'app.coupons'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('CartCoupons') ? [] : ['className' => 'App\Model\Table\CartCouponsTable'];
        $this->CartCoupons = TableRegistry::get('CartCoupons', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CartCoupons);

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
