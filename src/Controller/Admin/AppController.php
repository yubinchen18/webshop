<?php
namespace App\Controller\Admin;

use Cake\Core\Configure;
use Cake\Controller\Controller;
use Cake\Event\Event;
use App\Controller\AppController as BaseController;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends BaseController
{
    
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Auth', [
            'authorize' => ['Controller'],
            'loginAction' => [
                'prefix' => 'admin',
                'controller' => 'Users',
                'action' => 'login',
            ],
            'loginRedirect' => [
                'prefix' => 'admin',
                'controller' => 'Users',
                'action' => 'index',
            ],
            'logoutRedirect' => [
                'prefix' => 'admin',
                'controller' => 'Users',
                'action' => 'login',
            ],
            'unauthorizedRedirect' => '/admin/login',
            'authError' => __('U heeft geen toegang tot deze locatie.'),
            'flash' => [
                'element' => 'default',
                'params' => [
                    'class' => 'error',
                ],
            ],
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'username',
                        'password' => 'password',
                    ],
                    'userModel' => 'Users'
                ],
            ]
        ]);

        $authuser = $this->Auth->user();
        $this->set(compact('authuser'));
    }
}
