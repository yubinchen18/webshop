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
        'app.addresses'
    ];

    /*
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
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $mock = new \Cake\Validation\Validator();
        $validator = $this->Schools->validationDefault($mock);
        $this->assertEquals($mock, $validator);
    }
    
    public function testFindSearchException()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $query = $this->Schools->find('search');
    }
    
    public function testFindSearch()
    {
        $query = $this->Schools->find('search', ['searchTerm' => 'van putten']);
        $this->assertInstanceOf('Cake\ORM\Query', $query);
        $result = $query->count();
        $expected = 1;
        $this->assertEquals($expected, $result);
    }
}
