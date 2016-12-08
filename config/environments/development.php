<?php
use Cake\Core\Configure;
use Cake\Network\Request;

Configure::write('DiscountPrice', 3.98);

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
            'password' => 'S2Nwz3v0GGFfFzcrQ',
            'database' => 'hoogstraten_webshop',
            'encoding' => 'utf8',
            'timezone' => 'UTC',
            'cacheMetadata' => true,
            'quoteIdentifiers' => true,
            'log' => false
        ],
    ],
];
