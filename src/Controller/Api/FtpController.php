<?php
namespace App\Controller\Api;

use App\Controller\AppController\Api;
use Cake\Utility\Security;
use Cake\Core\Configure;
use Cake\Event\Event;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class FtpController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $host = "hoogstratenfotografie.nl";
        $user = "hoogstraten";
        $pass = "sy74NdLHGw";
        $path = ROOT ."/userphotos/";

        $this->set('Host', $host);
        $this->set('User', $user);
        $this->set('Pass', $pass);
        $this->set('Path', $path);
    }
}
