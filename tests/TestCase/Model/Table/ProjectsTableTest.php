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
        'app.schools'
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
    
    public function testBuildRules()
    {
        $mock = new \Cake\ORM\RulesChecker();
        $rules = $this->Projects->buildRules($mock);
        $this->assertEquals($mock, $rules);
    }
    
    public function testFindSearchException()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $query = $this->Projects->find('search');
    }
    
    public function testFindSearch()
    {
        $query = $this->Projects->find('search', ['searchTerm' => 'Eindej']);
        $this->assertInstanceOf('Cake\ORM\Query', $query);
        $result = $query->count();
        $expected = 1;
        $this->assertEquals($expected, $result);
    }
}
