<?php
namespace App\Controller\Supplier;

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
            'prefix' => 'supplier',
            'controller' => 'Users',
            'action' => 'login',
        ]);
        $this->Auth->config('loginRedirect', [
            'prefix' => 'supplier',
            'controller' => 'Orders',
            'action' => 'index'
        ]);
        $this->Auth->config('logoutRedirect', [
            'prefix' => 'supplier',
            'controller' => 'Users',
            'action' => 'login',
        ]);
        $this->Auth->config(
            'unauthorizedRedirect',
            [
                'prefix' => 'supplier',
                'controller' => 'Users',
                'action' => 'login'
            ]
        );
        $authuser = $this->Auth->user();
        $this->set(compact('authuser'));
    }
}
