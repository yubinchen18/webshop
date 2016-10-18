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
        $userId = '61d2a03c-08f9-400b-9942-9d2f3a843aaa';
        $cart = $this->Carts->checkExistingCart($userId);
        $allcarts = $this->Carts->find()->all();
        $this->assertEquals(1, count($allcarts));
        $this->assertEquals('1db1f83f-1b45-464b-b239-1e0651ba2710', $cart->id);
    }
}
