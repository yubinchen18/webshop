<?php
namespace App\Test\TestCase\Controller;

use App\Controller\UpdateController;
use Cake\TestSuite\IntegrationTestCase;
use App\Test\TestCase\BaseIntegrationTestCase;

/**
 * App\Controller\UpdateController Test Case
 */
class UpdateControllerTest extends BaseIntegrationTestCase
{
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.users',
        'app.logs',
    ];

    public function setUp()
    {
        parent::setUp();
        
    }

    /**
     * Test check_update
     *
     * @return void
     */
    public function testCheckUpdateXseeding()
    {
        $this->setBasicAuth('xseeding', 'xseeding');
        $this->get('/api/v1/check_update.json');
        $this->assertResponseSuccess();

        $expected = [
            'Version' => '1.0.0.146',
            'Files' => [
                'http:///updates/1_0_0_146/update.exe'
            ]
        ];
        $data = $this->getDecodedResponse();
        $this->assertEquals($expected, $data);
    }

    /**
     * Test check_update
     *
     * @return void
     */
    public function testCheckUpdatePhotographers()
    {
        $this->setBasicAuth();
        $this->get('/api/v1/check_update.json');
        $this->assertResponseSuccess();

        $expected = [
            'Version' => '1.0.0.145',
            'Files' => [
                'http:///updates/1_0_0_145/update.exe'
            ]
                
        ];
        $data = $this->getDecodedResponse();
        $this->assertEquals($expected, $data);
    }
}
