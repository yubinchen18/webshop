<?php
namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestCase;
use App\Test\TestCase\BaseIntegrationTestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\AppController Test Case
 */
class LogsControllerTest extends BaseIntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.users',
        'app.logs',
        'app.persons',
        'app.photos',
        'app.barcodes',
        'app.groups',
        'app.projects',
        'app.downloadqueues'
    ];

    public function setUp()
    {
        parent::setUp();
        $this->setBasicAuth();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testGet()
    {
        $this->get('/api/v1/get_ftp_login.json');
        $this->assertResponseSuccess();

        $this->Logs = TableRegistry::get('Logs');

        $logs = $this->Logs->find()
                ->toArray();
        $this->assertCount(2, $logs);
    }

    /**
     * Test beforeFilter method
     *
     * @return void
     */
    public function testGetWithParams()
    {
        $this->get('/api/v1/get_photos/persons/1447e1dd-f3a5-4183-9508-725519b3107d.json');
        $this->assertResponseSuccess();

        $this->Logs = TableRegistry::get('Logs');

        $logs = $this->Logs->find()
                ->toArray();
        $this->assertCount(2, $logs);
    }

    /**
     * Test beforeRender method
     *
     * @return void
     */
    public function testPost()
    {
        $data = [
            'Groups' => [ //offline aangemaakt
                "id"=> 2271,
                "online_id"=> 0,
                "project_id"=> '4a7d8a96-08f6-441c-a8d5-eb40440e7603',
                "barcode_id"=> 0,
                "url"=> "onbekend",
                "name"=> "Onbekend",
                "created"=> "\/Date(1393486879563)\/",
                "modified"=> "\/Date(1393486879563)\/",
                "deleted"=> false,
            ]
        ];

        $this->post('/api/v1/upload_item.json', $data);

        $this->assertResponseSuccess();
        $this->Logs = TableRegistry::get('Logs');

        $logs = $this->Logs->find()
                ->toArray();
        $this->assertCount(2, $logs);
    }
}
