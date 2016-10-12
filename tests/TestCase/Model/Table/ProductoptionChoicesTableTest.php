<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProductoptionChoicesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProductoptionChoicesTable Test Case
 */
class ProductoptionChoicesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ProductoptionChoicesTable
     */
    public $ProductoptionChoices;

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

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ProductoptionChoices') ? []
            : ['className' => 'App\Model\Table\ProductoptionChoicesTable'];
        $this->ProductoptionChoices = TableRegistry::get('ProductoptionChoices', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProductoptionChoices);

        parent::tearDown();
    }

    public function testCheckIdByName()
    {
        $optionName = 'Kleurbewerking';
        $optionValue = 'sepia';
        $optionChoiceId = $this->ProductoptionChoices->checkIdByName($optionName, $optionValue);
        
        $optionName2 = 'Uitvoering';
        $optionValue2 = 'glans';
        $optionChoiceId2 = $this->ProductoptionChoices->checkIdByName($optionName2, $optionValue2);
        
        $this->assertEquals('b6155209-2c1f-46b8-b164-cb5cff20b0d1', $optionChoiceId);
        $this->assertEquals('7c9cf742-9758-4493-9ee6-5015139b814e', $optionChoiceId2);
    }
}
