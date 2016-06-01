<?php
use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::defaultRouteClass('DashedRoute');

Router::scope('/', function (RouteBuilder $routes) {

    Router::prefix('Admin', function ($routes) {

        $routes->connect('/login', ['controller' => 'Users', 'action' => 'login']);
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
        
        $routes->connect('/dashboard', ['controller' => 'Pages', 'action' => 'display']);
    });

    $routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);
    $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    $routes->fallbacks('DashedRoute');
});

Plugin::routes();
