<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CartlinesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CartlinesTable Test Case
 */
class CartlinesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CartlinesTable
     */
    public $CartlinesTable;

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
        $config = TableRegistry::exists('Cartlines') ? [] : ['className' => 'App\Model\Table\CartlinesTable'];
        $this->CartlinesTable = TableRegistry::get('Cartlines', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CartlinesTable);

        parent::tearDown();
    }

    /**
     * Test checkExistingCartline method
     *
     * @return void
     */
    public function testCheckExistingCartlineReturnsExisting()
    {
        $cartId = '1db1f83f-1b45-464b-b239-1e0651ba2710';
        $productId = '3a1bef8f-f977-4a0e-8c29-041961247d2d';
        $hash = '3c7000c3dc91896e823fae5253b8d270';
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
            'product_id' => $productId,
            'product_name' => 'product1',
            'product_options' => $productOptions,
            'product_price' => 9.99,
            'quantity' => 5
        ];
        
        $cartline = $this->CartlinesTable->checkExistingCartline($cartId, $hash);
        $this->assertEquals('97e1c06c-7a87-468d-80d2-766a982214de', $cartline->id);
    }
    
    /**
     * Test checkExistingCartline method
     *
     * @return void
     */
    public function testCheckExistingCartlineReturnsNew()
    {
        $cartId = '1db1f83f-1b45-464b-b239-1e0651ba2710';
        $productId = '3a1bef8f-f977-4a0e-8c29-041961247d2d';
        $productOptions = [
            0 => [
                'name' => 'Uitvoering',
                'value' => 'glans',
                'icon' => 'layout/Hoogstraten_webshop-onderdelen-25.png',
            ],
            1 => [
                'name' => 'Kleurbewerking',
                'value' => 'geen',
                'icon' => 'layout/Hoogstraten_webshop-onderdelen-33.png'
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
        
        $cartline = $this->CartlinesTable->checkExistingCartline($cartId, $productId, $productOptions);
        $this->assertEquals(true, $cartline->isNew());
    }
}
