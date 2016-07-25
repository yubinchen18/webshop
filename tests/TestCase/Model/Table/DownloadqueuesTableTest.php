<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DownloadqueuesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DownloadqueuesTable Test Case
 */
class DownloadqueuesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DownloadqueuesTable
     */
    public $Downloadqueues;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [];

     /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Downloadqueues') ? [] : ['className' => 'App\Model\Table\DownloadqueuesTable'];
        $this->Downloadqueues = TableRegistry::get('Downloadqueues', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Downloadqueues);

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
        $validator = $this->Downloadqueues->validationDefault($mock);
        $this->assertEquals($mock, $validator);
    }
}
