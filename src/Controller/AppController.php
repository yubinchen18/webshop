<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
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

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        
        echo  'INSERT INTO `users` (`id`,`username`,`password`,`real_pass`,`email`,`type`,`created`,`modified`) '
                . 'VALUES '
                . '('
                . 'UUID(),'
                . '"hoogstraten",'
                . '"$2y$10$dBK/7unj8TKx3amOUJjui.ImChzUBZTDYLFPtQuso3KMpsrbPQQZy",'
                . '"staging",'
                . '"admin@xseeding.nl",'
                . '"basic",'
                . 'NOW(),'
                . 'NOW()'
                . ')'; die;
        if(Configure::read('environment') == 'staging') {
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
}
