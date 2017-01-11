<?php
use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::defaultRouteClass('DashedRoute');

Router::scope('/', function (RouteBuilder $routes) {

    $routes->extensions(['csv','json']);
     
    $routes->connect('/', ['controller' => 'Users', 'action' => 'login']);
    $routes->connect('/inloggen', ['controller' => 'Users', 'action' => 'login']);
    $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);
   
    $routes->connect('/photos', ['controller' => 'Photos', 'action' => 'index']);
    $routes->connect(
        '/photos/:size/:id',
        [
            'controller' => 'Photos',
            'action' => 'display',
        ],
        ['path', 'id', 'pass' => ['size','id']]
    );
    $routes->connect(
        '/photos/view/:id',
        ['controller' => 'Photos', 'action' => 'view'],
        ['id' => RouteBuilder::UUID, 'pass' => ['id']]
    );
    $routes->connect(
        '/photos/product-group/digital',
        ['controller' => 'Photos', 'action' => 'digitalIndex']
    );
    $routes->connect(
        '/photos/product-group/:productGroup/:id/**',
        ['controller' => 'Photos', 'action' => 'productGroupIndex'],
        ['productGroup', 'id' => RouteBuilder::UUID, 'pass' => ['productGroup', 'id', 'filter']]
    );
    $routes->connect(
        '/photos/product/:layout/:id/:suffix',
        [
            'controller' => 'Photos',
            'action' => 'displayProduct',
        ],
        ['layout', 'id', 'suffix', 'pass' => ['layout','id' ,'suffix']]
    );
    $routes->connect(
        '/photos/filter',
        ['controller' => 'Photos', 'action' => 'filterProductGroupIndex']
    );
    $routes->connect(
        '/photos/pickfreegroupspicture/:id',
        ['controller' => 'Photos', 'action' => 'pickFreeGroupsPicture'],
        ['id' => RouteBuilder::UUID, 'pass' => ['id']]
    );
    $routes->connect(
        '/photos/changefreegroupspicture/:id/:orderlineid',
        ['controller' => 'Photos', 'action' => 'changeFreeGroupsPicture'],
        ['id' => RouteBuilder::UUID, 'pass' => ['id', 'orderlineid']]
    );
    $routes->connect(
        '/orders/download/:id',
        ['controller' => 'Orders', 'action' => 'download'],
        ['id' => RouteBuilder::UUID, 'pass' => ['id']]
    );
    $routes->connect('/login', ['controller' => 'Users', 'action' => 'login']);
    $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);
    
    $routes->connect('/carts/beforeAdd', [
        'controller' => 'Carts',
        'action' => 'beforeAdd',
    ]);
    $routes->connect('/carts/add', [
        'controller' => 'Carts',
        'action' => 'add'
    ]);
    $routes->connect('/carts/display', [
        'controller' => 'Carts',
        'action' => 'display'
    ]);
    $routes->connect('/carts/update', [
        'controller' => 'Carts',
        'action' => 'update'
    ]);
    $routes->connect('/carts/updateFreeProductInCartline', [
        'controller' => 'Carts',
        'action' => 'updateFreeProductInCartline'
    ]);
    $routes->connect('/carts/useCoupon', [
        'controller' => 'Carts',
        'action' => 'useCoupon'
    ]);
    $routes->connect(
        '/carts/delete/:id',
        ['controller' => 'Carts','action' => 'delete'],
        ['pass' => ['model','id']]
    );
    $routes->connect('/carts/orderInfo', [
        'controller' => 'Carts',
        'action' => 'orderInfo'
    ]);
    $routes->connect('/carts/confirm', [
        'controller' => 'Carts',
        'action' => 'confirm'
    ]);
    $routes->connect(
        '/carts/zipcode/:zipcode',
        ['controller' => 'Carts', 'action' => 'zipcode'],
        ['zipcode', 'pass' => ['zipcode']]
    );
    $routes->connect(
        '/orders/:action',
        ['controller' => 'Orders'],
        []
    );
    
    Router::prefix('admin', function ($routes) {
        
        $routes->extensions(['csv','json']);
        
        $routes->connect('/login', ['controller' => 'Users', 'action' => 'login']);
        $routes->connect('/inloggen', ['controller' => 'Users', 'action' => 'login']);
        $routes->connect('/users/logout', ['controller' => 'Users', 'action' => 'logout']);
        $routes->connect('/users', ['controller' => 'Users', 'action' => 'index']);
        $routes->connect('/users/add', ['controller' => 'Users', 'action' => 'add']);
        $routes->connect(
            '/users/view/:id',
            ['controller' => 'Users', 'action' => 'view'],
            ['id' => RouteBuilder::UUID, 'pass' => ['id']]
        );
        $routes->connect(
            '/users/edit/:id',
            ['controller' => 'Users', 'action' => 'edit'],
            ['id' => RouteBuilder::UUID, 'pass' => ['id']]
        );
        $routes->connect(
            '/users/delete/:id',
            ['controller' => 'Users', 'action' => 'delete'],
            ['id' => RouteBuilder::UUID, 'pass' => ['id']]
        );
        $routes->connect(
            '/users/displayProfilePhoto/:id',
            ['controller' => 'Users', 'action' => 'displayProfilePhoto'],
            ['id' => RouteBuilder::UUID, 'pass' => ['id']]
        );

        $routes->connect('/schools', ['controller' => 'Schools', 'action' => 'index']);
        $routes->connect('/schools/add', ['controller' => 'Schools', 'action' => 'add']);
        $routes->connect(
            '/schools/view/:id',
            ['controller' => 'Schools', 'action' => 'view'],
            ['id' => RouteBuilder::UUID, 'pass' => ['id']]
        );
        $routes->connect(
            '/schools/edit/:id',
            ['controller' => 'Schools', 'action' => 'edit'],
            ['id' => RouteBuilder::UUID, 'pass' => ['id']]
        );
        $routes->connect(
            '/schools/delete/:id',
            ['controller' => 'Schools', 'action' => 'delete'],
            ['id' => RouteBuilder::UUID, 'pass' => ['id']]
        );
        $routes->connect(
            '/schools/export',
            ['controller' => 'Schools', 'action' => 'export'],
            ['id' => RouteBuilder::UUID, 'pass' => ['id']]
        );
        
        $routes->connect('/projects', ['controller' => 'Projects', 'action' => 'index']);
        $routes->connect(
            '/projects/:school_id',
            [
            'controller' => 'Projects',
            'action' => 'schoolprojects'
            ],
            [
                'school_id' => RouteBuilder::UUID,
                'pass' => ['school_id']
            ]
        );
        $routes->connect('/projects/add', ['controller' => 'Projects', 'action' => 'add']);
        $routes->connect(
            '/projects/view/:id',
            ['controller' => 'Projects', 'action' => 'view'],
            ['id' => RouteBuilder::UUID, 'pass' => ['id']]
        );
        $routes->connect(
            '/projects/edit',
            ['controller' => 'Projects', 'action' => 'edit']
        );
        $routes->connect(
            '/projects/edit/:id',
            ['controller' => 'Projects', 'action' => 'edit'],
            ['id' => RouteBuilder::UUID, 'pass' => ['id']]
        );
        $routes->connect(
            '/projects/delete/:id',
            ['controller' => 'Projects', 'action' => 'delete'],
            ['id' => RouteBuilder::UUID, 'pass' => ['id']]
        );
        $routes->connect(
            '/projects/createProjectCards/:id',
            ['controller' => 'Projects', 'action' => 'createProjectCards'],
            ['id' => RouteBuilder::UUID, 'pass' => ['id']]
        );

        $routes->connect('/groups', ['controller' => 'Groups', 'action' => 'index']);
        $routes->connect(
            '/groups/:project_id',
            [
            'controller' => 'Groups',
            'action' => 'projectgroups'
            ],
            [
                'school_id' => RouteBuilder::UUID,
                'pass' => ['project_id']
            ]
        );
        $routes->connect('/groups/add', ['controller' => 'Groups', 'action' => 'add']);
        $routes->connect(
            '/groups/view/:id',
            ['controller' => 'Groups', 'action' => 'view'],
            ['id' => RouteBuilder::UUID, 'pass' => ['id']]
        );
        $routes->connect(
            '/groups/edit/:id',
            ['controller' => 'Groups', 'action' => 'edit'],
            ['id' => RouteBuilder::UUID, 'pass' => ['id']]
        );
        $routes->connect(
            '/groups/delete/:id',
            ['controller' => 'Groups', 'action' => 'delete'],
            ['id' => RouteBuilder::UUID, 'pass' => ['id']]
        );
        $routes->connect(
            '/groups/createGroupCards/:id',
            ['controller' => 'Groups', 'action' => 'createGroupCards'],
            ['id' => RouteBuilder::UUID, 'pass' => ['id']]
        );

        $routes->connect('/persons', ['controller' => 'Persons', 'action' => 'index']);
        $routes->connect('/persons/add', ['controller' => 'Persons', 'action' => 'add']);
        $routes->connect(
            '/persons/view/:id',
            ['controller' => 'Persons', 'action' => 'view'],
            ['id' => RouteBuilder::UUID, 'pass' => ['id']]
        );
        $routes->connect(
            '/persons/edit/:id',
            ['controller' => 'Persons', 'action' => 'edit'],
            ['id' => RouteBuilder::UUID, 'pass' => ['id']]
        );
        $routes->connect(
            '/persons/delete/:id',
            ['controller' => 'Persons', 'action' => 'delete'],
            ['id' => RouteBuilder::UUID, 'pass' => ['id']]
        );
        $routes->connect(
            '/persons/createPersonCard/:id',
            ['controller' => 'Persons', 'action' => 'createPersonCard'],
            ['id' => RouteBuilder::UUID, 'pass' => ['id']]
        );
        $routes->connect(
            '/persons/showPhotosStudent/:id',
            ['controller' => 'Persons', 'action' => 'showPhotosStudent'],
            ['id' => RouteBuilder::UUID, 'pass' => ['id']]
        );

        $routes->connect(
            '/photos/:size/:path/:rotate',
            [
                    'controller' => 'Photos',
                    'action' => 'display',
                ],
            ['size','path','rotate', 'pass' => ['size','path','rotate']]
        );
        $routes->connect(
            '/photos/:size/:path',
            [
                    'controller' => 'Photos',
                    'action' => 'display',
                ],
            ['size','path', 'pass' => ['size','path']]
        );
        
        $routes->connect('/photos/move', ['controller' => 'Photos', 'action' => 'move']);
        $routes->connect('/photos', ['controller' => 'Photos', 'action' => 'index']);
        $routes->connect('/photos/add', ['controller' => 'Photos', 'action' => 'add']);
        $routes->connect(
            '/photos/view/:id',
            ['controller' => 'Photos', 'action' => 'view'],
            ['id' => RouteBuilder::UUID, 'pass' => ['id']]
        );
        $routes->connect(
            '/photos/edit/:id',
            ['controller' => 'Photos', 'action' => 'edit'],
            ['id' => RouteBuilder::UUID, 'pass' => ['id']]
        );
        $routes->connect(
            '/photos/delete/:id',
            ['controller' => 'Photos', 'action' => 'delete'],
            ['id' => RouteBuilder::UUID, 'pass' => ['id']]
        );
        
        $routes->connect('/orders', ['controller' => 'Orders', 'action' => 'index']);
        $routes->connect(
            '/orders/view/:id',
            ['controller' => 'Orders', 'action' => 'view'],
            ['id' => RouteBuilder::UUID, 'pass' => ['id']]
        );
        $routes->connect(
            '/orders/edit/:id',
            ['controller' => 'Orders', 'action' => 'edit'],
            ['id' => RouteBuilder::UUID, 'pass' => ['id']]
        );
        $routes->connect(
            '/orders/delete/:id',
            ['controller' => 'Orders', 'action' => 'delete'],
            ['id' => RouteBuilder::UUID, 'pass' => ['id']]
        );
        
        $routes->connect(
            '/searches/showResults',
            ['controller' => 'Searches', 'action' => 'showResults']
        );
        
        $routes->connect('/dashboard', ['controller' => 'Pages', 'action' => 'display']);
        $routes->connect('/', ['controller' => 'Pages', 'action' => 'display']);
        
        $routes->fallbacks('InflectedRoute');
    });
    
    Router::prefix('api', function ($routes) {
        $routes->extensions(['json']);

        $routes->connect('/v1/get_download_queue', [
            'controller' => 'Downloadqueues',
            'action' => 'listQueue',
            '_ext' => 'json'
        ]);
        $routes->connect('/v1/remove_queue_items', [
            'controller' => 'Downloadqueues',
            'action' => 'removeFromQueue',
            '_ext' => 'json'
        ]);
        $routes->connect('/v1/upload_item', [
            'controller' => 'Downloadqueues',
            'action' => 'uploadItem',
            '_ext' => 'json'
        ]);

        $routes->connect('/v1/check_update', ['controller' => 'Update', 'action' => 'index', '_ext' => 'json']);
        $routes->connect(
            '/v1/get_photos/:model/:id',
            ['controller' => 'Photos', 'action' => 'getPhotos', '_ext' => 'json'],
            ['pass' => ['model','id']]
        );

        $routes->connect(
            '/v1/get_photo/:id',
            ['controller' => 'Photos', 'action' => 'getPhoto', '_ext' => 'json'],
            ['id' => RouteBuilder::UUID, 'pass' => ['id']]
        );
    });
    
    Router::prefix('supplier', function ($routes) {
        $routes->extensions(['json']);
        
        $routes->connect('/', ['controller' => 'Users', 'action' => 'login']);
        $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);
        $routes->connect(
            '/photos/:size/:path/:rotate',
            [
                    'controller' => 'Photos',
                    'action' => 'display',
                ],
            ['size','path','rotate', 'pass' => ['size','path','rotate']]
        );
        $routes->connect(
            '/photos/:size/:path',
            [
                    'controller' => 'Photos',
                    'action' => 'display',
                ],
            ['size','path', 'pass' => ['size','path']]
        );
        $routes->connect('/orders', ['controller' => 'Orders', 'action' => 'index']);
        $routes->connect(
            '/orders/view/:id',
            ['controller' => 'Orders', 'action' => 'view'],
            ['id' => RouteBuilder::UUID, 'pass' => ['id']]
        );
        $routes->connect(
            '/orders/edit/:id',
            ['controller' => 'Orders', 'action' => 'edit'],
            ['id' => RouteBuilder::UUID, 'pass' => ['id']]
        );
        $routes->connect(
            '/searches/showResults',
            ['controller' => 'Searches', 'action' => 'showResults']
        );
        
        $routes->connect(
            '/orders/download/:id',
            ['controller' => 'Orders', 'action' => 'download'],
            ['id' => RouteBuilder::UUID, 'pass' => ['id']]);
    });
});

Plugin::routes();
