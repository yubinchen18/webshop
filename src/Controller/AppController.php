<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

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
        $this->loadComponent('Auth', [
            'authorize' => ['Controller'],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login',
            ],
            'loginRedirect' => '/',
            'logoutRedirect' => '/',
            'unauthorizedRedirect' => '/',
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
        
        //fetch user portraits and pass them to navbar
        $loggedUsers = $this->request->session()->read('LoggedInUsers.AllUsers');
        $userPortraits = [];
        if (isset($loggedUsers)) {
            foreach($loggedUsers as $loggedUser) {
                $portrait = TableRegistry::get('Users')->getUserPortrait($loggedUser);
                $userPortraits[] = $portrait;
            }
            $this->set(compact('userPortraits'));
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
        
        //persons not allowed to admin
        if (isset($this->request->params['prefix']) && $this->request->params['prefix'] === 'admin') {
            return (bool)($user['type'] === 'admin');
        }
        
        if ($user) {
            return true;
        }

        //by default nothing is allowed
        return false;
    }
}
