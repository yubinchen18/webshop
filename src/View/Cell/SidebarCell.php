<?php
namespace App\View\Cell;

use Cake\View\Cell;
use Cake\Controller\Exception\AuthSecurityException;

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
        $menu = $this->getMenu($user['type']);

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
                        'name' => __('Orders'),
                        'url' => ['controller' => 'Orders', 'action' => 'index', 'prefix' => 'admin'],
                        'icon' => 'fa fa-credit-card',
                        'children' => [
                            [
                                'name' => __('Overzicht'),
                                'url' => ['controller' => 'Orders', 'action' => 'index', 'prefix' => 'admin']
                            ]
                        ]
                    ],
                    [
                        'name' => __('Gebruikers'),
                        'url' => ['controller' => 'Users', 'action' => 'index', 'prefix' => 'admin'],
                        'icon' => 'fa fa-users',
                        'children' => [
                            [
                                'name' => __('Overzicht'),
                                'url' => ['controller' => 'Users', 'action' => 'index', 'prefix' => 'admin']
                            ],
                            [
                                'name' => __('Gebruiker toevoegen'),
                                'url' => ['controller' => 'Users', 'action' => 'add', 'prefix' => 'admin']
                            ],
                        ]
                    ],
                    [
                        'name' => __('Scholen'),
                        'url' => ['controller' => 'Schools', 'action' => 'index', 'prefix' => 'admin'],
                        'icon' => 'fa fa-building-o',
                        'children' => [
                            [
                                'name' => __('Overzicht'),
                                'url' => ['controller' => 'Schools', 'action' => 'index', 'prefix' => 'admin']
                            ],
                            [
                                'name' => __('School toevoegen'),
                                'url' => ['controller' => 'Schools', 'action' => 'add', 'prefix' => 'admin']
                            ],
                        ]
                    ],
                    [
                        'name' => __('Projects'),
                        'url' => ['controller' => 'Projects', 'action' => 'index', 'prefix' => 'admin'],
                        'icon' => 'fa fa-briefcase',
                        'children' => [
                            [
                                'name' => __('Overzicht'),
                                'url' => ['controller' => 'Projects', 'action' => 'index', 'prefix' => 'admin']
                            ],
                            [
                                'name' => __('Project toevoegen'),
                                'url' => ['controller' => 'Projects', 'action' => 'add', 'prefix' => 'admin']
                            ],
                        ]
                    ],
                    [
                        'name' => __('Klassen'),
                        'url' => ['controller' => 'Groups', 'action' => 'index', 'prefix' => 'admin'],
                        'icon' => 'fa fa-users',
                        'children' => [
                            [
                                'name' => __('Overzicht'),
                                'url' => ['controller' => 'Groups', 'action' => 'index', 'prefix' => 'admin']
                            ],
                            [
                                'name' => __('Klas toevoegen'),
                                'url' => ['controller' => 'Groups', 'action' => 'add', 'prefix' => 'admin']
                            ],
                        ]
                    ],
                    [
                        'name' => __('Personen'),
                        'url' => ['controller' => 'Persons', 'action' => 'index', 'prefix' => 'admin'],
                        'icon' => 'fa fa-user',
                        'children' => [
                            [
                                'name' => __('Overzicht'),
                                'url' => ['controller' => 'Persons', 'action' => 'index', 'prefix' => 'admin']
                            ],
                            [
                                'name' => __('Persoon toevoegen'),
                                'url' => ['controller' => 'Persons', 'action' => 'add', 'prefix' => 'admin']
                            ],
                        ]
                    ],
                    [
                        'name' => __('Foto\'s'),
                        'url' => ['controller' => 'photos', 'action' => 'index', 'prefix' => 'admin'],
                        'icon' => 'fa fa-camera',
                        'children' => [
                        ]
                    ],
                    
                ];
case 'user':
                return [
                    [
                        'name' => __('Dashboard'),
                        'url' => ['controller' => 'Pages', 'action' => 'display', 'prefix' => 'admin'],
                        'icon' => 'fa fa-tachometer'
                    ],
                ];
        }
        throw new AuthSecurityException('Userrole not found');
    }
}
