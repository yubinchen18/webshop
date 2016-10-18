<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CartlineProductoptionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CartlineProductoptionsTable Test Case
 */
class CartlineProductoptionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CartlineProductoptionsTable
     */
    public $CartlineProductoptionsTable;

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
        $config = TableRegistry::exists('CartlineProductoptions') ? []
            : ['className' => 'App\Model\Table\CartlineProductoptionsTable'];
        $this->CartlineProductoptionsTable = TableRegistry::get('CartlineProductoptions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CartlineProductoptionsTable);

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
        $validator = $this->CartlineProductoptionsTable->validationDefault($mock);
        $this->assertEquals($mock, $validator);
    }
}
