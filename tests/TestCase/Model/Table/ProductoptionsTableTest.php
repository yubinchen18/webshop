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
    public $Productoptions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.productoptions',
        'app.productoption_choices',
        'app.products',
        'app.orderlines',
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
        $this->Productoptions = TableRegistry::get('Productoptions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Productoptions);

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
