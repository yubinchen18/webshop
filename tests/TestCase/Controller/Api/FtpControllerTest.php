<?php
namespace App\Test\TestCase\Controller;

use App\Controller\FtpController;
use Cake\TestSuite\IntegrationTestCase;
use App\Test\TestCase\BaseIntegrationTestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\FtpController Test Case
 */
class FtpControllerTest extends BaseIntegrationTestCase
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
        'app.logs'
    ];

    public function setUp()
    {
        parent::setUp();
        $this->setBasicAuth();
    }

    /**
     * Test get_ftp_login
     *
     * @return void
     */
    public function testGetFtpLogin()
    {
        $this->get('/api/v1/get_ftp_login.json');
        $this->assertResponseSuccess();

        $expected = [
                
                    'Host' => 'hoogstratenfotografie.nl',
                    'User' => 'hoogstraten',
                    'Pass' => 'sy74NdLHGw',
                    'Path' => '/httpdocs/app/userphotos/',
                
        ];
        $data = $this->getDecodedResponse();
        
        $this->assertEquals($expected, $data);
    }
}
