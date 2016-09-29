<?php
namespace App\Test\TestCase\Controller;

use App\Controller\PhotosController;
use App\Test\TestCase\BaseIntegrationTestCase;
use Cake\TestSuite\IntegrationTestCase;
use Cake\ORM\TableRegistry;
use Cake\Filesystem\File;
use App\Lib\ImageHandler;

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
        'app.products'
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
                    'id' => '91017bf5-5b19-438b-bd44-b0c4e1eaf903',
                    'username' => 'person',
                    'password' => '$2y$10$JBK87/tveJzabHpc7kcaxuXNqpIBwihGRnnp8s6jTWZh.SC8itldy', //photex
                    'genuine' => '968e999ace62ee0f0956c43fe3c2289917d71cc02c86906fa85e517d1946deed', //photex
                    'email' => 'person@person.nl',
                    'type' => 'person',
                    'created' => '2016-05-25 09:02:25',
                    'modified' => '2016-05-25 09:02:25',
                    'deleted' => null,
                    'address_id' => '0a2d28b2-cd01-4a11-afd5-e96d8d7f3ee3'
                ]
            ],
            'LoggedInUsers' => [
                'AllUsers' => [0 => '91017bf5-5b19-438b-bd44-b0c4e1eaf903'],
                'ActiveUser' => '91017bf5-5b19-438b-bd44-b0c4e1eaf903'
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
        $testpersons = $this->viewVariable('persons');
        $this->assertTrue(isset($testpersons));
        $this->assertInstanceOf('App\Model\Entity\Person', $testpersons[0]);
        $this->assertEquals('df99d62f-258c-424d-a1fe-af3213e70867', $testpersons[0]->barcode_id);
    }
    
    public function testIndexPersonNotFound()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => '1447e1dd-f3a5-4183-9508-111111111111',
                    'username' => 'dontexist',
                    'password' => '$2y$10$JBK87/tveJzabHpc7kcaxuXNqpIBwihGRnnp8s6jTWZh.SC8itldy', //photex
                    'genuine' => '968e999ace62ee0f0956c43fe3c2289917d71cc02c86906fa85e517d1946deed', //photex
                    'email' => 'dontexist@person.nl',
                    'type' => 'person',
                    'created' => '2016-05-25 09:02:25',
                    'modified' => '2016-05-25 09:02:25',
                    'deleted' => null,
                    'address_id' => '0a2d28b2-cd01-4a11-afd5-e96d8d7f3ee3'
                ]
            ],
            'LoggedInUsers' => [
                'AllUsers' => [0 => '1447e1dd-f3a5-4183-9508-111111111111'],
                'ActiveUser' => '1447e1dd-f3a5-4183-9508-111111111111'
            ]
        ]);
        $this->get('/photos');
        $this->assertResponseOk();
        $this->assertResponseContains('Person not found.');
    }
     
    public function testViewLoadHorizontalPhoto()
    {
        $this->get('/photos/view/277d32ec-b56c-44fa-a10a-ddfcb86c19f8');
        $photo = $this->viewVariable('photo');
        $this->assertTrue(isset($photo));
        $this->assertEquals('horizontal.jpeg', $photo->path);
        $this->assertEquals('photos-horizontal', $photo->orientationClass);
        $this->assertResponseOk();
    }
    
    public function testViewLoadVerticalPhoto()
    {
        $this->get('/photos/view/59d395fa-e723-43f0-becb-0078425f9a27');
        $photo = $this->viewVariable('photo');
        $this->assertTrue(isset($photo));
        $this->assertEquals('tes2t.jpg', $photo->path);
        $this->assertEquals('photos-vertical', $photo->orientationClass);
    }
    
    public function testViewPhotoNotFound()
    {
        $this->get('/photos/view/277d32ec-b56c-44fa-a10a-ddfcb8611111');
        $this->assertResponseError();
        $this->assertResponseCode(404);
    }
    
    public function testViewWrongPersonViewOthersPhoto()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => '91017bf5-5b19-438b-bd44-b0c4e1eaf904',
                    'username' => 'person2',
                    'password' => '$2y$10$JBK87/tveJzabHpc7kcaxuXNqpIBwihGRnnp8s6jTWZh.SC8itldy', //photex
                    'genuine' => '968e999ace62ee0f0956c43fe3c2289917d71cc02c86906fa85e517d1946deed', //photex
                    'email' => 'person2@person.nl',
                    'type' => 'person',
                    'created' => '2016-05-25 09:02:25',
                    'modified' => '2016-05-25 09:02:25',
                    'deleted' => null,
                    'address_id' => '0a2d28b2-cd01-4a11-afd5-e96d8d7f3ee3'
                ]
            ],
            'LoggedInUsers' => [
                'AllUsers' => [0 => '91017bf5-5b19-438b-bd44-b0c4e1eaf904'],
                'ActiveUser' => '91017bf5-5b19-438b-bd44-b0c4e1eaf904'
            ]
        ]);
        $this->get('/photos/view/277d32ec-b56c-44fa-a10a-ddfcb86c19f8');
        $this->assertResponseCode(404);
        $this->assertResponseContains('Not authorized to view this photo');
    }
    
    public function testDisplayPhotoIdNotFound()
    {
        $this->get('/photos/display/thumbs/idbestaatniet');
        $this->assertResponseContains('Cake\Network\Exception\NotFoundException');
        $this->assertResponseCode(404);
    }
    
    public function testDisplayRandomSize()
    {
        $this->get('/photos/asdfeager/277d32ec-b56c-44fa-a10a-ddfcb86c19f8');
        $this->assertContentType('jpeg');
        $this->assertFileResponse(ROOT.'/tests/Fixture/'
                . 'de-ring-van-putten/eindejaars-2016/klas-2a/pieter-vos/horizontal.jpeg');
    }
    
    public function testDisplayOriginalPhoto()
    {
        $this->get('/photos/original/277d32ec-b56c-44fa-a10a-ddfcb86c19f8');
        $this->assertContentType('jpeg');
        $this->assertFileResponse(ROOT . '/tests/Fixture/'
                . 'de-ring-van-putten/eindejaars-2016/klas-2a/pieter-vos/horizontal.jpeg');
    }
    
    public function testDisplayThumbPhoto()
    {
        $this->get('/photos/thumbs/277d32ec-b56c-44fa-a10a-ddfcb86c19f8');
        $this->assertContentType('jpeg');
        $this->assertFileResponse(ROOT.'/tests/Fixture/'
                . 'de-ring-van-putten/eindejaars-2016/klas-2a/pieter-vos/thumbs/horizontal.jpeg');
    }
    
    public function testDisplayMedPhoto()
    {
        $this->get('/photos/med/277d32ec-b56c-44fa-a10a-ddfcb86c19f8');
        $this->assertContentType('jpeg');
        $this->assertFileResponse(ROOT.'/tests/Fixture/'
                . 'de-ring-van-putten/eindejaars-2016/klas-2a/pieter-vos/med/horizontal.jpeg');
    }

    public function testProductGroupIndexLoadHorizontalPhoto()
    {
        $this->get('/photos/product-group/combination-sheets/277d32ec-b56c-44fa-a10a-ddfcb86c19f8');
        $photo = $this->viewVariable('photo');
        $this->assertTrue(isset($photo));
        $this->assertEquals('horizontal.jpeg', $photo->path);
        $this->assertEquals('photos-horizontal', $photo->orientationClass);
    }
    
    public function testProductGroupIndexLoadVerticalPhoto()
    {
        $this->get('/photos/product-group/combination-sheets/59d395fa-e723-43f0-becb-0078425f9a27');
        $photo = $this->viewVariable('photo');
        $this->assertTrue(isset($photo));
        $this->assertEquals('tes2t.jpg', $photo->path);
        $this->assertEquals('photos-vertical', $photo->orientationClass);
    }
    
    public function testProductGroupIndexPhotoNotFound()
    {
        $this->get('/photos/product-group/combination-sheets/277d32ec-b56c-44fa-a10a-ddfcb8611111');
        $this->assertResponseError();
        $this->assertResponseCode(404);
    }
    
    public function testProductGroupIndexWrongPersonViewOthersPhoto()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => '91017bf5-5b19-438b-bd44-b0c4e1eaf904',
                    'username' => 'person2',
                    'password' => '$2y$10$JBK87/tveJzabHpc7kcaxuXNqpIBwihGRnnp8s6jTWZh.SC8itldy', //photex
                    'genuine' => '968e999ace62ee0f0956c43fe3c2289917d71cc02c86906fa85e517d1946deed', //photex
                    'email' => 'person2@person.nl',
                    'type' => 'person',
                    'created' => '2016-05-25 09:02:25',
                    'modified' => '2016-05-25 09:02:25',
                    'deleted' => null,
                    'address_id' => '0a2d28b2-cd01-4a11-afd5-e96d8d7f3ee3'
                ]
            ],
            'LoggedInUsers' => [
                'AllUsers' => [0 => '91017bf5-5b19-438b-bd44-b0c4e1eaf904'],
                'ActiveUser' => '91017bf5-5b19-438b-bd44-b0c4e1eaf904'
            ]
        ]);
        $this->get('/photos/product-group/combination-sheets/277d32ec-b56c-44fa-a10a-ddfcb86c19f8');
        $this->assertResponseCode(404);
        $this->assertResponseContains('Not authorized to view this photo');
    }
    
    public function testProductGroupIndexLoadProducts()
    {
        $this->get('/photos/product-group/combination-sheets/277d32ec-b56c-44fa-a10a-ddfcb86c19f8');
        $products = $this->viewVariable('products');
        $this->assertTrue(isset($products));
        $this->assertEquals(count($products), 1);
        $this->assertEquals('CombinationLayout1', $products[0]->layout);
        $this->assertEquals('combination-sheets', $products[0]->product_group);
    }
    
    public function testProductGroupIndexNoProductFound()
    {
        $this->get('/photos/product-group/non-existing-group/277d32ec-b56c-44fa-a10a-ddfcb86c19f8');
        $this->assertResponseCode(404);
        $this->assertResponseContains('No products found.');
    }
    
    public function testDisplayProduct()
    {
        $testTmpDir = ROOT.'/tests/Fixture/';
        $this->get('/photos/product/CombinationLayout2/277d32ec-b56c-44fa-a10a-ddfcb86c19f8/200180?path='.$testTmpDir);
        $this->assertContentType('jpeg');
        $this->assertFileResponse(ROOT . '/tests/Fixture/'
                . '71ee6675cd2ae1588c79172fc7b28614.jpg');
    }
    
    public function testDisplayProductNoPhotoFound()
    {
        $testTmpDir = ROOT.'/tests/Fixture/';
        $this->get(
            '/photos/product/CombinationLayout2/277d32ec-b56c-44fa-a10a-ddfcb86notexist/200180?path='.$testTmpDir
        );
        $this->assertResponseContains('Cake\Network\Exception\NotFoundException');
        $this->assertResponseCode(404);
    }
}
