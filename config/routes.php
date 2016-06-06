<?php
use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::defaultRouteClass('DashedRoute');

Router::scope('/', function (RouteBuilder $routes) {

    $routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);
    $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    $routes->fallbacks('DashedRoute');

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

        $routes->connect('/projects', ['controller' => 'Projects', 'action' => 'index']);
        $routes->connect('/projects/add', ['controller' => 'Projects', 'action' => 'add']);
        $routes->connect(
            '/projects/view/:id',
            ['controller' => 'Projects', 'action' => 'view'],
            ['id' => RouteBuilder::UUID, 'pass' => ['id']]
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

        $routes->connect('/groups', ['controller' => 'Groups', 'action' => 'index']);
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


        $routes->connect('/dashboard', ['controller' => 'Pages', 'action' => 'display']);
        $routes->connect('/', ['controller' => 'Pages', 'action' => 'display']);
    });
});

Plugin::routes();
