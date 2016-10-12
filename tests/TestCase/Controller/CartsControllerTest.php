<?php
namespace App\Test\TestCase\Controller;

use App\Controller\CartsController;
use App\Test\TestCase\BaseIntegrationTestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\CartsController Test Case
 */
class CartsControllerTest extends BaseIntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.carts',
        'app.cartlines',
        'app.cartlineProductoptions',
        'app.products',
    ];
    
    public function setUp()
    {
        parent::setUp();
        $this->loginPerson();
        $this->Carts = TableRegistry::get('Carts');
    }
    
    /**
     * Test add method
     *
     * @return void
     */
    public function testAddC()
    {
        $_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
        $productOptions = [
            0 => [
                'name' => 'Uitvoering',
                'value' => 'glans',
                'icon' => 'layout/Hoogstraten_webshop-onderdelen-25.png',
            ],
            1 => [
                'name' => 'Kleurbewerking',
                'value' => 'geen',
                'icon' => 'layout/Hoogstraten_webshop-onderdelen-31.png'
            ]
        ];

        $data = [
            'photo_id' => '277d32ec-b56c-44fa-a10a-ddfcb86c19f8',
            'product_id' => '3a1bef8f-f977-4a0e-8c29-041961247d2d',
            'product_name' => 'product1',
            'product_options' => $productOptions,
            'product_price' => 9.99,
            'quantity' => 5
        ];
       
        $this->post('/carts/add', $data); //route
        $cart = $this->Carts->find()->all();
//        pr($cart);die();
//        $this->assertEquals()
        
        
//        debug($this->_response->body());
        
        
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
