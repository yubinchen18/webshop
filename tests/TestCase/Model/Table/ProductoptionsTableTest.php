<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProductoptionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProductoptionsTable Test Case
 */
class ProductoptionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ProductoptionsTable
     */
    public $ProductoptionsTable;

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
        $config = TableRegistry::exists('Productoptions') ? [] : ['className' => 'App\Model\Table\ProductoptionsTable'];
        $this->ProductoptionsTable = TableRegistry::get('Productoptions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProductoptionsTable);

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
        $validator = $this->ProductoptionsTable->validationDefault($mock);
        $this->assertEquals($mock, $validator);
    }
}
