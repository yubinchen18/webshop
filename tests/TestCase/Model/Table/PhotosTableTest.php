<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PhotosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PhotosTable Test Case
 */
class PhotosTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PhotosTable
     */
    public $Photos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.barcodes',
        'app.groups',
        'app.projects',
        'app.schools',
        'app.persons'
    ];

     /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Photos') ? [] : ['className' => 'App\Model\Table\PhotosTable'];
        $this->Photos = TableRegistry::get('Photos', $config);
    }

    public function testGetPathGroupType() 
    {
        $path = $this->Photos->getPath('6844d1e7-d6b2-4e23-8bbe-d671b698d1c3');
        $this->assertTextEndsWith('de-ring-van-putten/eindejaars-2016/groep-8b', $path);
    }
    
    public function testGetPathPersonType()
    {
        $path = $this->Photos->getPath('105ea78c-2e11-4b7f-b42c-05443169d43a');
        $this->assertTextEndsWith('de-ring-van-putten/eindejaars-2016/klas-2a/jan-de-boer', $path);
    }
    
    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Photos);

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
        $validator = $this->Photos->validationDefault($mock);
        $this->assertEquals($mock, $validator);
    }
}
