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
    public $Cartlines;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        
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
        $this->Cartlines = TableRegistry::get('Cartlines', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Cartlines);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
