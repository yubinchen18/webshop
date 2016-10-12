<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProductsProductoptionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProductsProductoptionsTable Test Case
 */
class ProductsProductoptionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ProductsProductoptionsTable
     */
    public $ProductsProductoptionsTable;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.cartline_productoptions',
        'app.cartlines',
        'app.carts',
        'app.users',
        'app.addresses',
        'app.persons',
        'app.groups',
        'app.projects',
        'app.schools',
        'app.barcodes',
        'app.photos',
        'app.orders',
        'app.products',
        'app.productoptions',
        'app.productoption_choices',
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
        $config = TableRegistry::exists('ProductsProductoptions') ? []
            : ['className' => 'App\Model\Table\ProductsProductoptionsTable'];
        $this->ProductsProductoptionsTable = TableRegistry::get('ProductsProductoptions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProductsProductoptionsTable);

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
        $validator = $this->ProductsProductoptionsTable->validationDefault($mock);
        $this->assertEquals($mock, $validator);
    }
}
