<?php
use Cake\Core\Configure;
use Cake\Network\Request;

$config = [
    'debug' => false,
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
