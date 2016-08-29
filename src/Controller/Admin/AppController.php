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
        
        $this->Auth->config('loginAction', [
                'prefix' => 'admin',
                'controller' => 'Users',
                'action' => 'login',
            ]);
        $this->Auth->config('loginRedirect', [
                'prefix' => 'admin',
                'controller' => 'Users',
                'action' => 'index'
            ]);
        $this->Auth->config('logoutRedirect', [
                'prefix' => 'admin',
                'controller' => 'Users',
                'action' => 'login',
            ]);
        $this->Auth->config('unauthorizedRedirect',
                '/admin/login'
            );
        $authuser = $this->Auth->user();
        $this->set(compact('authuser'));
    }
    
    public function beforeFilter(Event $event)
    {
    }
}
