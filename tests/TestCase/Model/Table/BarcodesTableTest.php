<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BarcodesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BarcodesTable Test Case
 */
class BarcodesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BarcodesTable
     */
    public $Barcodes;

     /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [];

    /*
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Barcodes') ? [] : ['className' => 'App\Model\Table\BarcodesTable'];
        $this->Barcodes = TableRegistry::get('Barcodes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Barcodes);

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
        $validator = $this->Barcodes->validationDefault($mock);
        $this->assertEquals($mock, $validator);
    }
}
