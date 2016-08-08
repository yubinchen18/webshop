<?php
namespace App\Test\TestCase\Controller\Admin;

use App\Controller\Admin\PhotosController;
use App\Test\TestCase\BaseIntegrationTestCase;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\PhotosController Test Case
 */
class PhotosControllerTest extends BaseIntegrationTestCase
{
    /**
     * Fixtures
     *
     * @var array
     *
     * @var type
     */
    public $fixtures = [
        'app.users',
        'app.persons',
        'app.projects',
        'app.groups',
        'app.photos',
        'app.barcodes',
        'app.schools',
        'app.logs'
    ];

    public function setUp()
    {
        parent::setUp();
        $this->loginAdmin();
        $this->Projects = TableRegistry::get('Projects');
    }

    public function testIndexUnfiltered()
    {
        $this->get('/admin/photos');
        $photos = $this->viewVariable('photos');
        
        $this->assertEquals(4, $photos->count());
    }
    
    public function testIndexFiltered()
    {
        $data = [
            'school_id' => '82199cab-fc52-4853-8f64-575a7721b8e7',
            'project_id' => '4a7d8a96-08f6-441c-a8d5-eb40440e7603',
            'group_id' => 'e5b778cd-68cd-469f-88b3-37846b984868'            
        ];
        $this->post('/admin/photos', $data);
        $photos = $this->viewVariable('photos');
        
        $this->assertEquals(2, $photos->count());
    }
    
    public function testView() 
    {
        $photo_id = '277d32ec-b56c-44fa-a10a-ddfcb86c19f8';
        $this->get('/admin/photos/view/'.$photo_id);
        
        $this->assertResponseOk();
        $photo = $this->viewVariable('photo');
        
        $this->assertEquals('test3.jpg', $photo->path);
        $this->assertEquals('3333', $photo->barcode->barcode); 
    }
    
    public function testMoveWithoutPost() 
    {
        $this->get('/admin/photos/move');
        $this->assertRedirect('/admin/photos');
    }
    
    public function testMoveOne() 
    {
        $model = $this->getMockForModel('\App\Model\Table\PhotosTable', ['move']);
        $model->method('move')->will($this->returnValue(true));
        
        $data['photos'] = [
            '277d32ec-b56c-44fa-a10a-ddfcb86c19f8' => 1,
            'a18bfc55-1095-4764-9154-810849a1a664' => 0,
            '123327ea-7e67-48bc-b7f6-49d9d880a356' => 0
        ];
        
        $this->post('/admin/photos/move', $data);
        
        $this->assertResponseOk();
        $this->assertResponseContains('Tank,  Henk  de');
        $this->assertResponseContains('3333');
        
        $data = [
                'photos' => ['277d32ec-b56c-44fa-a10a-ddfcb86c19f8'],
                'destination_id' => '0fdcdf18-e0a9-43c0-b254-d373eefb79a0',
            ];
        
        $this->post('/admin/photos/move',$data);
        $this->assertRedirect('/admin/photos');
        
        $photos = TableRegistry::get('Photos');
        $moved  = $photos->get('277d32ec-b56c-44fa-a10a-ddfcb86c19f8',[
            'contain' => 'Barcodes'
        ]);
        $this->assertEquals('5555',$moved->barcode->barcode);
    }

    public function tearDown() {
        parent::tearDown();
        TableRegistry::clear();
    }
}
