<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CartsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CartsTable Test Case
 */
class CartsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CartsTable
     */
    public $Carts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.carts',
        'app.users',
        'app.cartlines',
        'app.cartline_productoptions',
        'app.productoptions',
        'app.productoption_choices',
        'app.photos',
        'app.products'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Carts') ? [] : ['className' => 'App\Model\Table\CartsTable'];
        $this->Carts = TableRegistry::get('Carts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Carts);

        parent::tearDown();
    }

    /**
     *
     */
    public function testReturnNewCart()
    {
        $userId = '91017bf5-5b19-438b-bd44-b0c4e1eaf903';
        $this->Carts->checkExistingCart($userId);
        $allcarts = $this->Carts->find()->all();
        $this->assertEquals(2, count($allcarts));
    }
    
    public function testReturnExistingCart()
    {
        $userId = 'c4b06162-5bfa-4f1c-af86-694ddecd24a2';
        $cart = $this->Carts->checkExistingCart($userId);
        $allcarts = $this->Carts->find()->all();
        $this->assertEquals(2, count($allcarts));
        $this->assertEquals('1db1f83f-1b45-464b-b239-1e0651ba2710', $cart->id);
    }
}
