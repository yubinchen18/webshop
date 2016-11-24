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
        'app.users',
        'app.photos',
        'app.productoptions',
        'app.productoption_choices',
        'app.persons',
        'app.barcodes',
        'app.groups',
        'app.projects',
        'app.schools',
    ];
    
    public function setUp()
    {
        parent::setUp();
        $this->loginPerson();
        $this->Carts = TableRegistry::get('Carts');
        $this->Photos = TableRegistry::get('Photos');
        $this->Persons = TableRegistry::get('Persons');
        $this->Photos->baseDir = APP . '..' . DS . 'tests' . DS . 'Fixture';
    }
    
    public function testBeforeAddOk()
    {
        $_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
        $data = [
            'cartline' => [
                'photo_id' => '277d32ec-b56c-44fa-a10a-ddfcb86c19f8',
                'product_id' => '3a1bef8f-f977-4a0e-8c29-041961247d2d',
                'product_name' => 'product1',
                'product_options' => [
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
                ],
                'product_price' => 9.99
            ]
        ];
        
        $this->post('/carts/beforeAdd', $data); //route
        
        $expected = '{"photo_id":"277d32ec-b56c-44fa-a10a-ddfcb86c19f8",'
                . '"product_id":"3a1bef8f-f977-4a0e-8c29-041961247d2d",'
                . '"product_name":"product1","product_options":'
                . '[{"name":"Uitvoering","value":"glans",'
                . '"icon":"layout\/Hoogstraten_webshop-onderdelen-25.png"},'
                . '{"name":"Kleurbewerking","value":"geen",'
                . '"icon":"layout\/Hoogstraten_webshop-onderdelen-31.png"}],'
                . '"product_price":9.99,'
                . '"discount_price":0}';
        $this->assertResponseContains($expected);
    }
    
    public function testBeforeAddWrongMethod()
    {
        $this->get('/carts/beforeAdd'); //route
        $this->assertResponseContains('Bad Request');
    }
    
    
    /**
     * Test add method
     *
     * @return void
     */
    public function testAddToNewCart()
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
        $this->post('/carts/add.json', $data); //route
        $carts = $this->Carts->find()->all();
        $this->assertEquals(2, count($carts));
    }
    
    public function testAddToExistingCart()
    {
        $this->loginPerson2();
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
        $this->post('/carts/add.json', $data); //route
//        91017bf5-5b19-438b-bd44-b0c4e1eaf903
        $carts = $this->Carts->find()->all();
        $this->assertEquals(2, count($carts));
    }
    
    public function testAddNewCartline()
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
        $this->post('/carts/add.json', $data); //route
        $carts = $this->Carts->find()->all()->toArray();
        $cartlines = $this->Carts->Cartlines->find()
                ->contain(['CartlineProductoptions.ProductoptionChoices'])
                ->all();
        $newCartline = $this->Carts->Cartlines->find()
                ->where(['cart_id' => $carts[0]->id])
                ->contain(['CartlineProductoptions.ProductoptionChoices'])
                ->first();
        $newCartlineOption1 = $this->Carts->Cartlines->CartlineProductoptions->find()
                ->where(['cartline_id' => $newCartline->id])
                ->matching('ProductoptionChoices', function ($q) {
                    return $q->where(['ProductoptionChoices.value' => 'glans']);
                })
                ->toArray();
        $newCartlineOption2 = $this->Carts->Cartlines->CartlineProductoptions->find()
                ->where(['cartline_id' => $newCartline->id])
                ->matching('ProductoptionChoices', function ($q) {
                    return $q->where(['ProductoptionChoices.value' => 'geen']);
                })
                ->toArray();
        $this->assertEquals(2, count($carts));
        $this->assertEquals(3, count($cartlines));
        $this->assertEquals('59d395fa-e723-43f0-becb-0078425f9a99', $newCartline->photo_id);
        $this->assertEquals('3a1bef8f-f977-4a0e-8c29-041961247d2d', $newCartline->product_id);
        $this->assertEquals(5, $newCartline->quantity);
        $this->assertEquals(2, count($newCartline->cartline_productoptions));
        $this->assertEquals(1, count($newCartlineOption1));
        $this->assertEquals(0, count($newCartlineOption2));
        //debug($this->_response->body());
    }
    
    public function testEditExistingCartlineWithNewQuantity()
    {
        $this->loginPerson2();
        $_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
        $productOptions = [
            0 => [
                'name' => 'Uitvoering',
                'value' => 'glans',
                'icon' => 'layout/Hoogstraten_webshop-onderdelen-25.png',
            ],
            1 => [
                'name' => 'Kleurbewerking',
                'value' => 'sepia',
                'icon' => 'layout/Hoogstraten_webshop-onderdelen-33.png'
            ]
        ];

        $data = [
            'photo_id' => '59d395fa-e723-43f0-becb-0078425f9a99',
            'product_id' => '3a1bef8f-f977-4a0e-8c29-041961247d2d',
            'product_name' => 'product1',
            'product_options' => $productOptions,
            'product_price' => 9.99,
            'quantity' => 5
        ];
        $this->post('/carts/add.json', $data); //route
        $carts = $this->Carts->find()->all()->toArray();
        $cartlines = $this->Carts->Cartlines->find()
                ->contain(['CartlineProductoptions.ProductoptionChoices'])
                ->all();
        $newCartline = $this->Carts->Cartlines->find()
                ->where(['cart_id' => $carts[0]->id])
                ->contain(['CartlineProductoptions.ProductoptionChoices'])
                ->first();
        $newCartlineOption1 = $this->Carts->Cartlines->CartlineProductoptions->find()
                ->where(['cartline_id' => $newCartline->id])
                ->matching('ProductoptionChoices', function ($q) {
                    return $q->where(['ProductoptionChoices.value' => 'glans']);
                })
                ->toArray();
        $newCartlineOption2 = $this->Carts->Cartlines->CartlineProductoptions->find()
                ->where(['cartline_id' => $newCartline->id])
                ->matching('ProductoptionChoices', function ($q) {
                    return $q->where(['ProductoptionChoices.value' => 'sepia']);
                })
                ->toArray();
        
        $this->assertEquals(2, count($carts));
        $this->assertEquals(3, count($cartlines));
        $this->assertEquals('59d395fa-e723-43f0-becb-0078425f9a99', $newCartline->photo_id);
        $this->assertEquals('3a1bef8f-f977-4a0e-8c29-041961247d2d', $newCartline->product_id);
        $this->assertEquals(5, $newCartline->quantity);
        $this->assertEquals(2, count($newCartline->cartline_productoptions));
        $this->assertEquals(1, count($newCartlineOption1));
        $this->assertEquals(1, count($newCartlineOption2));
    }
    
    public function testAddNewCartlineWithExistingProductWithDifferentOptions()
    {
        $this->loginPerson2();
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
            'photo_id' => '59d395fa-e723-43f0-becb-0078425f9a99',
            'product_id' => '3a1bef8f-f977-4a0e-8c29-041961247d2d',
            'product_name' => 'product1',
            'product_options' => $productOptions,
            'product_price' => 9.99,
            'quantity' => 3
        ];
        $this->post('/carts/add.json', $data); //route
        $carts = $this->Carts->find()->all()->toArray();
        $cartlines = $this->Carts->Cartlines->find()
                ->contain(['CartlineProductoptions.ProductoptionChoices'])
                ->all();

        $newCartline = $this->Carts->Cartlines->find()
                ->where(['cart_id' => $carts[0]->id])
                ->contain(['CartlineProductoptions.ProductoptionChoices'])
                ->last();
        $newCartlineOption1 = $this->Carts->Cartlines->CartlineProductoptions->find()
                ->where(['cartline_id' => $newCartline->id])
                ->matching('ProductoptionChoices', function ($q) {
                    return $q->where(['ProductoptionChoices.value' => 'glans']);
                })
                ->toArray();
        $newCartlineOption2 = $this->Carts->Cartlines->CartlineProductoptions->find()
                ->where(['cartline_id' => $newCartline->id])
                ->matching('ProductoptionChoices', function ($q) {
                    return $q->where(['ProductoptionChoices.value' => 'geen']);
                })
                ->toArray();
        
        $this->assertEquals(2, count($carts));
        $this->assertEquals(3, count($cartlines));
        $this->assertEquals('59d395fa-e723-43f0-becb-0078425f9a99', $newCartline->photo_id);
        $this->assertEquals('3a1bef8f-f977-4a0e-8c29-041961247d2d', $newCartline->product_id);
        $this->assertEquals(5, $newCartline->quantity);
        $this->assertEquals(2, count($newCartline->cartline_productoptions));
        $this->assertEquals(1, count($newCartlineOption1));
        $this->assertEquals(0, count($newCartlineOption2));
    }
    
    public function testAddFails()
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
            'product_id' => '3a1bef8f-f977-4a0e-8c29-bestaatniet',
            'product_name' => 'product1',
            'product_options' => $productOptions,
            'product_price' => 9.99,
            'quantity' => 5
        ];
        $this->post('/carts/add.json', $data); //route
        $this->assertEquals([
            'success' => false,
            'message' => 'Could not save new cartline'
        ], $this->viewVariable('response'));
    }
    
    public function testAddOptionsFail()
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
                'value' => 'asdf',
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
        $this->post('/carts/add.json', $data); //route
        $this->assertEquals([
            'success' => false,
            'message' => 'Could not save product options to cartline'
        ], $this->viewVariable('response'));
    }
    
    public function testAddInvalidMethod()
    {
        $productOptions = [
            0 => [
                'name' => 'Uitvoering',
                'value' => 'glans',
                'icon' => 'layout/Hoogstraten_webshop-onderdelen-25.png',
            ],
            1 => [
                'name' => 'Kleurbewerking',
                'value' => 'asdf',
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
        $this->post('/carts/add.json', $data); //route
        $this->assertEquals(['success' => false, 'message' => 'Invalid method error'], $this->viewVariable('response'));
    }
    
    public function testAddDigitalProduct()
    {
        $this->markTestIncomplete('Not implemented yet.');
        $_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
        $data = [
            'photo_id' => '277d32ec-b56c-44fa-a10a-ddfcb86c19f8',
            'product_id' => '3373b17f-496d-4a57-bbc4-d39f5a2f644a',
            'product_name' => 'Digitaal alles',
            'product_price' => 35.00,
            'quantity' => 1
        ];
        print_r($carts = $this->Carts->find()->all());
        $this->post('/carts/add.json', $data);
        print_r($this->_response->body());
        die;
        $cartlines = $this->Carts->Cartlines->find()->toArray();
        $this->assertEquals(3, count($cartlines));
    }
    
    public function testUpdateCartlineWithNewPhotoId()
    {
        $_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
        $cartline = $this->Carts->Cartlines->find()->where(['id' => '752a97bc-ab5e-4197-a2da-71c86974b5e0'])->first();
        $this->assertEquals('59d395fa-e723-43f0-becb-0078425f9a99', $cartline->photo_id);
        
        $data = [
            'cartline_photo_id' => 'aff61452-fe0d-4d54-83d9-69400f4e4b2f',
            'cartline_id' => '752a97bc-ab5e-4197-a2da-71c86974b5e0'
        ];

        $this->post('/carts/updateFreeProductInCartline.json', $data);
        $cartline = $this->Carts->Cartlines->find()->where(['id' => '752a97bc-ab5e-4197-a2da-71c86974b5e0'])->first();
        $this->assertEquals('aff61452-fe0d-4d54-83d9-69400f4e4b2f', $cartline->photo_id);
    }
    
    public function testUpdateCartlineWithNewPhotoIdFailureEmptyCartline()
    {
        $_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';

        $data = [
            'cartline_photo_id' => 'aff61452-fe0d-4d54-83d9-69400f4e4b2f',
            'cartline_id' => ''
        ];

        $this->post('/carts/updateFreeProductInCartline.json', $data);
        $cartline = $this->Carts->Cartlines->find()->where(['id' => '752a97bc-ab5e-4197-a2da-71c86974b5e0'])->first();
         $this->assertEquals(['success' => false], $this->viewVariable('response'));
    }
    
    public function testUpdateCartlineWithNewPhotoIdFailureNotSaved()
    {
        $_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';

        $data = [
            'cartline_photo_id' => '',
            'cartline_id' => '752a97bc-ab5e-4197-a2da-71c86974b5e0'
        ];

        $this->post('/carts/updateFreeProductInCartline.json', $data);
        $cartline = $this->Carts->Cartlines->find()->where(['id' => '752a97bc-ab5e-4197-a2da-71c86974b5e0'])->first();
        $this->assertEquals(['success' => false], $this->viewVariable('response'));
    }
}
