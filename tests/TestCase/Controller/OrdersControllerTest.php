<?php
namespace App\Test\TestCase\Controller;

use App\Controller\OrdersController;
use App\Test\TestCase\BaseIntegrationTestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\OrdersController Test Case
 */
class OrdersControllerTest extends BaseIntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        $this->loginPerson();
        $this->Carts = TableRegistry::get('Carts');
        $this->Photos = TableRegistry::get('Photos');
        $this->Persons = TableRegistry::get('Persons');
        $this->Photos->baseDir = APP . '..' . DS . 'tests' . DS . 'Fixture';
    }
    
    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Persons);
        unset($this->Photos);

        parent::tearDown();
    }
    
    /**
     * Test download method
     *
     * @return void
     */
    public function testDownload($orderId = '79ac1071-1940-4513-9faf-f57893ca3ade')
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
