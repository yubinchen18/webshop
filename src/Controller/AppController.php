<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Controller\Controller;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
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

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        
        if (Configure::read('environment') == 'staging') {
            $this->loadComponent('Auth', [
                'authenticate' => [
                    'Basic' => ['finder' => 'auth']
                ],
                'storage' => 'Memory',
                'unauthorizedRedirect' => false
            ]);
        }
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }

    public function isAuthorized($user)
    {
        //admin can access everything
        if ($user['type'] == 'admin') {
            return true;
        }

        //photex is only allowed to the whielist: Controller [ allowedactions ]
        if ($user['type'] == 'photex') {
            $allowed = [
                'Users' => [
                    'index'
                ]
            ];

            if (isset($allowed[$this->request->params['controller']]) &&
                   in_array($this->request->params['action'], $allowed[$this->request->params['controller']]) ) {
                return true;
            }
            return false;
        }

        //by default nothing is allowed
        return false;
    }
}
