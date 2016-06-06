<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProjectsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProjectsTable Test Case
 */
class ProjectsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ProjectsTable
     */
    public $Projects;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.projects',
        'app.schools',
        'app.contacts',
        'app.addresses',
        'app.groups'
    ];

     /*
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Projects') ? [] : ['className' => 'App\Model\Table\ProjectsTable'];
        $this->Projects = TableRegistry::get('Projects', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Projects);

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
        $validator = $this->Projects->validationDefault($mock);
        $this->assertEquals($mock, $validator);
    }
}
