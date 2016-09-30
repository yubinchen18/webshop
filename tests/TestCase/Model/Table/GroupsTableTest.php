<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GroupsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GroupsTable Test Case
 */
class GroupsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\GroupsTable
     */
    public $Groups;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.groups',
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
        $config = TableRegistry::exists('Groups') ? [] : ['className' => 'App\Model\Table\GroupsTable'];
        $this->Groups = TableRegistry::get('Groups', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Groups);

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
        $validator = $this->Groups->validationDefault($mock);
        $this->assertEquals($mock, $validator);
    }
    
    public function testFindSearchException()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $query = $this->Groups->find('search');
    }
    
    public function testFindSearch()
    {
        $query = $this->Groups->find('search', ['searchTerm' => 'Klas 2A']);
        $this->assertInstanceOf('Cake\ORM\Query', $query);
        $result = $query->toArray();
        $email = $result[0]->project->name;
        $expected = 'Eindejaars 2016';
        $this->assertEquals($expected, $email);
    }
}
