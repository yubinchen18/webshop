<?php
namespace App\View\Cell;

use Cake\View\Cell;

/**
 * Sidebar cell
 */
class SidebarCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Default display method.
     *
     * @return void
     */
    public function display($user)
    {
//        $userrole = empty($user['userrole']['name']) ? 'default' : $user['userrole']['name'];
        $userrole = 'admin';
        $menu = $this->getMenu($userrole);

        $this->set(compact('menu'));
    }

    /**
     * Method will return the menu for the given userrole
     * @return array
     */
    private function getMenu($userrole)
    {
        switch ($userrole) {
            case 'admin':
                return [
                    [
                        'name' => __('Dashboard'),
                        'url' => ['controller' => 'Pages', 'action' => 'display', 'prefix' => 'admin'],
                        'icon' => 'fa fa-tachometer'
                    ],
                    [
                        'name' => __('Users'),
                        'url' => ['controller' => 'Users', 'action' => 'index', 'prefix' => 'admin'],
                        'icon' => 'fa fa-users',
//                        'children' => [
//                            [
//                                'name' => __('overview'),
//                                'url' => ['controller' => 'Users', 'action' => 'index', 'prefix' => 'admin']
//                            ],
//                            [
//                                'name' => __('add user'),
//                                'url' => ['controller' => 'Users', 'action' => 'add', 'prefix' => 'admin']
//                            ],
//                        ]
                    ]
                ];
            case 'user':
                return [
                    [
                        'name' => __('Dashboard'),
                        'url' => ['controller' => 'Pages', 'action' => 'dashboard'],
                        'icon' => 'fa fa-tachometer'
                    ],
                ];
        }
        throw new AuthSecurityException('Userrole not found');
    }
}
