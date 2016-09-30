<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsersTable Test Case
 */
class UsersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\UsersTable
     */
    public $Users;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.users',
        'app.addresses',
        'app.persons',
        'app.groups',
        'app.schools',
        'app.barcodes',
        'app.photos',
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
        $config = TableRegistry::exists('Users') ? [] : ['className' => 'App\Model\Table\UsersTable'];
        $this->Users = TableRegistry::get('Users', $config);
        $this->Photos = TableRegistry::get('Photos');
        $this->Photos->baseDir = APP . '..' . DS . 'tests' . DS . 'Fixture';
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Users);

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
        $validator = $this->Users->validationDefault($mock);
        $this->assertEquals($mock, $validator);
    }
    
    public function testGetUserHorizontalPortrait()
    {
        $userId = '61d2a03c-08f9-400b-9942-9d2f3a843aaa';
        $photo = $this->Users->getUserPortrait($userId);
        $this->assertEquals('vertical.jpg', $photo->path);
        $this->assertTrue(isset($photo));
    }
    
    public function testGetUserVerticaltalPortrait()
    {
        $userId = '91017bf5-5b19-438b-bd44-b0c4e1eaf903';
        $photo = $this->Users->getUserPortrait($userId);
        $this->assertEquals('horizontal.jpeg', $photo->path);
        $this->assertTrue(isset($photo));
    }
    
    public function testGetUserPortraitNoPhoto()
    {
        $userId = '6f7d98cb-500a-4827-82e1-cdf2b59e106f';
        $photo = $this->Users->getUserPortrait($userId);
        $this->assertTrue(!isset($photo));
    }
}
