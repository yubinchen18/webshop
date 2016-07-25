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
}
