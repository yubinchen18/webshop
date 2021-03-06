<?php
namespace App\Test\TestCase;

use App\Utility\Text;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;
use Cake\Core\Configure;

/**
 * App\Controller\UsersController Test Case
 */
class BaseIntegrationTestCase extends IntegrationTestCase
{
    public function setUp()
    {
        parent::setUp();
        Configure::write('debug', true);
    }

    public function loginAdmin($user = null)
    {
        if (empty($user)) {
            $user = [
                'id' => '7f04642a-34a2-4d3d-ae8a-c79e26f5bbfa',
                'username' => 'xseeding',
                'password' => '$2y$10$eL2HDMMKWDyjApXdU/RMsuaDbeNvKmIW/zM08z8vpoRJJGb9UQYW2',
                'genuine' => '4865fb8fbc0b103aafa9428f687a602cefaebc99fb5f22012056cfa27706136b4VU',
                'email' => 'xseeding@xseeding.nl',
                'type' => 'admin',
                'created' => '2016-05-09 12:26:17',
                'modified' => '2016-05-09 12:26:17',
                'deleted' => null,
            ];
        }
        $this->session([
            'Auth' => [
                'User' => $user
            ]
        ]);
    }

    public function loginUser($user = null)
    {
        if (empty($user)) {
            $user = [
                'id' => '7f04642a-34a2-4d3d-ae8a-c79e26f5bbfa',
                'username' => 'xseeding',
                'password' => '$2y$10$eL2HDMMKWDyjApXdU/RMsuaDbeNvKmIW/zM08z8vpoRJJGb9UQYW2',
                'genuine' => '4865fb8fbc0b103aafa9428f687a602cefaebc99fb5f22012056cfa27706136b4VU',
                'email' => 'xseeding@xseeding.nl',
                'type' => 'admin',
                'created' => '2016-05-09 12:26:17',
                'modified' => '2016-05-09 12:26:17',
                'deleted' => null,
            ];
        }
        $this->session([
            'Auth' => [
                'User' => $user
            ]
        ]);
    }
    
    public function loginPerson($user = null)
    {
        if (empty($user)) {
            $user = [
                'id' => 'c4b06162-5bfa-4f1c-af86-694ddecd24a2',
                'username' => 'person',
                'password' => '$2y$10$JBK87/tveJzabHpc7kcaxuXNqpIBwihGRnnp8s6jTWZh.SC8itldy', //photex
                'genuine' => '968e999ace62ee0f0956c43fe3c2289917d71cc02c86906fa85e517d1946deed', //photex
                'email' => 'person@person.nl',
                'type' => 'person',
                'created' => '2016-05-25 09:02:25',
                'modified' => '2016-05-25 09:02:25',
                'deleted' => null,
                'address_id' => '0a2d28b2-cd01-4a11-afd5-e96d8d7f3ee3'
            ];
        }
        $this->session([
            'Auth' => [
                'User' => $user
            ],
            'LoggedInUsers' => [
                'AllUsers' => [0 => '91017bf5-5b19-438b-bd44-b0c4e1eaf903'],
                'ActiveUser' => '91017bf5-5b19-438b-bd44-b0c4e1eaf903'
            ]
        ]);
    }
    
    public function loginPerson2($user = null)
    {
        if (empty($user)) {
            $user = [
                'id' => '61d2a03c-08f9-400b-9942-9d2f3a843aaa',
                'username' => 'person2',
                'password' => '$2y$10$JBK87/tveJzabHpc7kcaxuXNqpIBwihGRnnp8s6jTWZh.SC8itldy', //photex
                'genuine' => '968e999ace62ee0f0956c43fe3c2289917d71cc02c86906fa85e517d1946deed', //photex
                'email' => 'person2@person.nl',
                'type' => 'person',
                'created' => '2016-05-25 09:02:25',
                'modified' => '2016-05-25 09:02:25',
                'deleted' => null,
                'address_id' => '0a2d28b2-cd01-4a11-afd5-e96d8d7f3ee3'
            ];
        }
        $this->session([
            'Auth' => [
                'User' => $user
            ],
            'LoggedInUsers' => [
                'AllUsers' => [0 => '61d2a03c-08f9-400b-9942-9d2f3a843aaa'],
                'ActiveUser' => '91017bf5-5b19-438b-bd44-b0c4e1eaf903'
            ]
        ]);
    }
    
    public function logout()
    {
        $this->session([
            'Auth' => null
        ]);
    }

    public function setBasicAuth($username = 'photographer', $password = 'photex')
    {
        $this->configRequest([
            'environment' => [
                'PHP_AUTH_USER' => $username,
                'PHP_AUTH_PW' => $password,
            ]
        ]);
    }

    public function assertUuid($text)
    {
        $this->assertEquals(preg_match('/([a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12})/', $text), 1);
    }

    public function assertActionLogged($action)
    {
        $actionlogstable = TableRegistry::get('Actionlogs');
        $actionlog = $actionlogstable->find()
            ->where(['Actionlogs.action' => $action, 'Actionlogs.created >=' => new \DateTime('-1 minute')])->first();
        $this->assertNotEmpty($actionlog);
    }

    protected function assertDecodedResponseEquals($expected, $message = '')
    {
        $decodedResponse = $this->getDecodedResponse($message, false);
        $this->assertEquals($expected, $decodedResponse);
    }

    protected function assertDecodedResponseContains($expected)
    {
        $decodedResponse = $this->getDecodedResponse(null, true);
        array_walk($expected, [$this, 'responseContains'], $decodedResponse);
    }

    protected function responseContains($expected, $key, $response)
    {
        if (is_array($expected)) {
            foreach ($expected as $subkey => $subvalue) {
                $this->responseContains($subvalue, $subkey, $response[$key]);
            }

            return;
        }
        $this->assertEquals($expected, $response[$key]);
    }

    protected function assertDecodedResponseRelations($expected)
    {
        $decodedResponse = $this->getDecodedResponse(null, true);

        if (isset($decodedResponse[0])) {
            $decodedResponse = $decodedResponse[0];
        }
        foreach ($expected as $value) {
            if (! Hash::check($decodedResponse, $value)) {
                $this->fail('Missing relation: ' . $value);
            }
            $this->assertTrue(Hash::check($decodedResponse, $value));
            $this->assertNotEmpty(Hash::get($decodedResponse, $value));
        }
    }

    protected function assertDecodedResponseCount($expected)
    {
        $decodedResponse = $this->getResponse(null, true);
        $this->assertCount($expected, $decodedResponse);
    }

    public function getDecodedResponse($message = null, $escapeDataKey = false)
    {
        if (! $this->_response) {
            $this->fail('No response set, cannot assert content. ' . $message);
        }

        $decodedResponse = json_decode($this->_response->body(), true);
        if ($escapeDataKey && isset($decodedResponse['data'])) {
            $decodedResponse = $decodedResponse['data'];
        }

        return $decodedResponse;
    }
}
