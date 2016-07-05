<?php
namespace App\Controller\Api;

use App\Controller\AppController\Api;
use Cake\Utility\Security;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Auth\BasicAuthenticate;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UpdateController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $profileName = $this->getUser();

        $version = "1.0.0.145";

        $files = [
            "http://". $this->request->env('HTTP_HOST') . "/updates/1_0_0_145/update.exe"
        ];

        if ($profileName == 'xseeding') {
            $version = "1.0.0.146";

            $files = [
                "http://". $this->request->env('HTTP_HOST') . "/updates/1_0_0_146/update.exe"
            ];
        }
        $this->set('Version', $version);
        $this->set('Files', $files);
    }
}
