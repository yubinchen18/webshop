<?php
use Cake\Core\Configure;
use Cake\Network\Request;

Configure::write('DiscountPrice', 3.98);
//Configure::write('App.fullBaseUrl','https://bestellen.hoogstratenfotografie.nl');
Configure::write('App.email','info@hoogstratenfotografie.nl');
Configure::write('App.title','Hoogstraten Fotografie B.V.');

$config = [
    'debug' => false,
    'environment' => 'production',
    'forceSsl' => false,
    'Datasources' => [
        'default' => [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Mysql',
            'persistent' => false,
            'host' => 'localhost',
            'username' => 'hoogstraten',
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
