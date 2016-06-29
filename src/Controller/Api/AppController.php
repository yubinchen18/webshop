<?php
namespace App\Controller\Api;

use Cake\Core\Configure;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Utility\Security;
use Cake\Network\Exception;

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
    private $requestLog;
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
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Basic' => [
                    'fields' => ['username' => 'username', 'password' => 'password'],
                    'userModel' => 'Users',
                    'finder' => 'basicAuthUsers',
                ],
            ],
            'storage' => 'Memory',
            'unauthorizedRedirect' => false,
            'realm'=>'Hoogstraten synchronisatie',
            'loginAction' => false
        ]);

    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->saveRequest();
    }

    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);
        $this->RequestHandler->renderAs($this, 'json');
        $this->response->type('application/json');
        $this->set('_serialize', true);

        $this->saveResponse();
    }

    public function getUser()
    {
        return $this->request->env('PHP_AUTH_USER');
    }

    private function saveRequest()
    {
        $this->Logs = TableRegistry::get('Logs');
        $entity = $this->Logs->newEntity();
        $entity->username = $this->getUser();
        $entity->url = $this->request->host() . $this->request->here;
        $entity->method = $this->request->method();
        
        $request = json_encode($this->request->data());
        if($this->request->method() == 'GET' &&
                isset($this->request->params['model']) &&
                isset($this->request->params['id'])) {
            $request = json_encode([
                'id' => $this->request->params['id'],
                'model' => $this->request->params['model']
            ]);
        }

        $entity->request = $request;
        return $this->requestLog = $this->Logs->save($entity);
    }

    private function saveResponse()
    {
        if(!isset($this->Logs)) {
            $this->Logs = TableRegistry::get('Logs');
        }

        $entity = $this->Logs->newEntity();
        if (!empty($this->requestLog)) {
            $entity = $this->Logs->get($this->requestLog->id);
        }

        $entity->response = json_encode($this->viewVars);
        return $this->Logs->save($entity);
    }
}
