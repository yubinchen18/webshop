<?php
namespace App\Test\TestCase\Controller;

use App\Controller\CartsController;
use App\Test\TestCase\BaseIntegrationTestCase;

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
        'app.carts'
    ];
    
    public function setUp()
    {
        parent::setUp();
        $this->loginPerson();
    }
    
    /**
     * Test index method
     *
     * @return void
     */
    public function testAddToCart()
    {
        $data = [ //postdata zelfde als ajax request
            'productId' => 'person',
            'optionId' => 'photex',
            'cartId' => 'uitleg',
        ];
       
        $this->post('/carts/add', $data); //route
        
        
        
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
     * Test add method
     *
     * @return void
     */
    public function testAdd()
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
