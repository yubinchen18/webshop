<?php
namespace App\Test\TestCase\Controller;

use App\Controller\PhotosController;
use App\Test\TestCase\BaseIntegrationTestCase;
use Cake\TestSuite\IntegrationTestCase;
use Cake\ORM\TableRegistry;
use Cake\Filesystem\File;

/**
 * App\Controller\PhotosController Test Case
 */
class PhotosControllerTest extends BaseIntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.photos',
        'app.barcodes',
        'app.groups',
        'app.projects',
        'app.schools',
        'app.contacts',
        'app.persons',
        'app.addresses',
        'app.users',
    ];
    
    public function setUp()
    {
        parent::setUp();
        
        $this->Photos = TableRegistry::get('Photos');
        $this->Persons = TableRegistry::get('Persons');
        $this->Photos->baseDir = APP . '..' . DS . 'tests' . DS . 'Fixture';
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => '1447e1dd-f3a5-4183-9508-725519b3107d',
                    'firstname' => 'Pieter'
                ]
            ]
        ]);
    }
    
    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Persons);
        unset($this->Photos);

        parent::tearDown();
    }
    
    /**
     * Test index method
     *
     * @return void
     */
    public function testIndexLoadPerson()
    {
        
        
        $this->get('/photos');
        $testperson = $this->viewVariable('person');
        $this->assertTrue(isset($testperson));
        $this->assertInstanceOf('App\Model\Entity\Person', $testperson);
        $this->assertEquals('df99d62f-258c-424d-a1fe-af3213e70867', $testperson->barcode_id);
    }
    
    public function testIndexPersonNotFound()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => '1447e1dd-f3a5-4183-9508-111111111111',
                    'firstname' => 'NotExistingPerson'
                ]
            ]
        ]);
        $this->get('/photos');
        $testperson = $this->viewVariable('person');
        $this->assertResponseOk();
        $this->assertResponseContains('This person is not found');
    }
    
    public function testDisplayPhotoIdNotFound()
    {
        $this->get('/photos/display/thumbs/idbestaatniet');
        $this->assertResponseContains('Cake\Network\Exception\NotFoundException');
        $this->assertResponseCode(404);
    }
    
    // @codingStandardsIgnoreStart
    public function testDisplayRandomSize()
    {
        $this->get('/photos/display/asdfeager/277d32ec-b56c-44fa-a10a-ddfcb86c19f8');
        $this->assertContentType('jpeg');
        $this->assertFileResponse('/var/www/webshop2016/tests/Fixture/de-ring-van-putten/eindejaars-2016/klas-2a/pieter-vos/horizontal.jpeg');
    }
    
    public function testDisplayOriginalPhoto()
    {
        $this->get('/photos/display/original/277d32ec-b56c-44fa-a10a-ddfcb86c19f8');
        $this->assertContentType('jpeg');
        $this->assertFileResponse('/var/www/webshop2016/tests/Fixture/de-ring-van-putten/eindejaars-2016/klas-2a/pieter-vos/horizontal.jpeg');
    }
    
    public function testDisplayThumbPhoto()
    {
        $this->get('/photos/display/thumbs/277d32ec-b56c-44fa-a10a-ddfcb86c19f8');
        $this->assertContentType('jpeg');
        $this->assertFileResponse('/var/www/webshop2016/tests/Fixture/de-ring-van-putten/eindejaars-2016/klas-2a/pieter-vos/thumbs/horizontal.jpeg');
    }
    
    public function testDisplayMedPhoto()
    {
        $this->get('/photos/display/med/277d32ec-b56c-44fa-a10a-ddfcb86c19f8');
        $this->assertContentType('jpeg');
        $this->assertFileResponse('/var/www/webshop2016/tests/Fixture/de-ring-van-putten/eindejaars-2016/klas-2a/pieter-vos/med/horizontal.jpeg');
    }
    // @codingStandardsIgnoreEnd
}