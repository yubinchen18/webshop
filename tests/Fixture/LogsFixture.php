<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LogsFixture
 *
 */
class LogsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'username' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'url' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'method' => ['type' => 'string', 'length' => 4, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'request' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'response' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 'a666c412-60ff-472d-99e5-6f27e6790267',
            'username' => 'photographer',
            'url' => '/api/v1/get_ftp_login.json',
            'method' => 'GET',
            'request' => '[]',
            'response' => '{"_serialize":true,"Path":"\/httpdocs\/app\/userphotos\/","Pass":"sy74NdLHGw","User":"hoogstraten","Host":"hoogstratenfotografie.nl"}',
            'created' => '2016-06-29 14:12:11'
        ],
    ];
}
