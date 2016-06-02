<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SchoolsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SchoolsTable Test Case
 */
class SchoolsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SchoolsTable
     */
    public $Schools;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.schools',
        'app.contacts',
        'app.visitaddresses',
        'app.mailaddresses',
        'app.projects'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Schools') ? [] : ['className' => 'App\Model\Table\SchoolsTable'];
        $this->Schools = TableRegistry::get('Schools', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Schools);

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

    /**
     * Test defaultConnectionName method
     *
     * @return void
     */
    public function testDefaultConnectionName()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
