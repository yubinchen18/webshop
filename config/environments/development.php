<?php
use Cake\Core\Configure;
use Cake\Network\Request;

Configure::write('DiscountPrice', 3.98);
Configure::write('App.fullBaseUrl', 'http://hoogstraten.local.dev.xseeding.nl');
Configure::write('App.email','info@hoogstratenfotografie.nl');
Configure::write('App.title','Hoogstraten Fotografie B.V.');

$config = [
    'debug' => true,
    'environment' => 'dev',
    'forceSsl' => false,
    'Datasources' => [
        'default' => [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Mysql',
            'persistent' => false,
            'host' => 'localhost',
            'username' => 'hoogstraten_webs',
            'password' => 'z7ZhrvvG9Nhmenf2',
            'database' => 'hoogstraten_webshop',
            'encoding' => 'utf8',
            'timezone' => 'UTC',
            'cacheMetadata' => true,
            'quoteIdentifiers' => true,
            'log' => false
        ],
    ],
];
