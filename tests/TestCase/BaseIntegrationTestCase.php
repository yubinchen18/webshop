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
    public function setUp() {
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
