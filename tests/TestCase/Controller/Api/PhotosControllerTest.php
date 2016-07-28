<?php
namespace App\Test\TestCase\Controller\Api;

use App\Controller\PhotosController;
use Cake\TestSuite\IntegrationTestCase;
use App\Test\TestCase\BaseIntegrationTestCase;
use Cake\ORM\TableRegistry;

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
        'app.logs'
    ];

    public function setUp()
    {
        parent::setUp();
        $this->setBasicAuth();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testPersonsPhotos()
    {
        $this->get('/api/v1/get_photos/persons/1447e1dd-f3a5-4183-9508-725519b3107d.json');
        $this->assertResponseSuccess();
        $data = $this->getDecodedResponse();
        $this->assertCount(2, $data['Photos']);
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testProjectsPhotos()
    {
        $this->get('/api/v1/get_photos/projects/4a7d8a96-08f6-441c-a8d5-eb40440e7603.json');
        $this->assertResponseSuccess();
        $data = $this->getDecodedResponse();
        $this->assertCount(4, $data['Photos']);
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testGroupsPhotos()
    {
        $this->get('/api/v1/get_photos/groups/e5b778cd-68cd-469f-88b3-37846b984868.json');
        $this->assertResponseSuccess();
        $data = $this->getDecodedResponse();
        $this->assertCount(2, $data['Photos']);
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testPhotoDownload()
    {
        $image = file_get_contents("https://www.google.com/images/srpr/logo3w.png");
        $this->assertEquals("\x89PNG\x0d\x0a\x1a\x0a", substr($image, 0, 8));
    }
}
