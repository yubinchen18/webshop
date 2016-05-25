<?php
use Cake\Core\Configure;
use Cake\Network\Request;

$config = [
    'debug' => false,
    'environment' => 'staging',
    'forceSsl' => false,
    'Datasources' => [
        'default' => [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Mysql',
            'persistent' => false,
            'host' => 'localhost',
            'username' => 'admin_hoogstrate',
            'password' => 'S2Nwz3v0GGFfFzcrQ',
            'database' => 'admin_hoogstraten',
            'encoding' => 'utf8',
            'timezone' => 'UTC',
            'cacheMetadata' => true,
            'quoteIdentifiers' => true,
            'log' => false
        ],
    ],
];

