<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 *
 */
class UsersFixture extends TestFixture
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
        'password' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'genuine' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'email' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'type' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'deleted' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'address_id' => ['type' => 'uuid', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'fk_users_addresses1_idx' => ['type' => 'index', 'columns' => ['address_id'], 'length' => []],
        ],
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
            'id' => '7f04642a-34a2-4d3d-ae8a-c79e26f5bbfa',
            'username' => 'xseeding',
            'password' => '$2y$10$eL2HDMMKWDyjApXdU/RMsuaDbeNvKmIW/zM08z8vpoRJJGb9UQYW2', //xseeding
            'genuine' => '4865fb8fbc0b103aafa9428f687a602cefaebc99fb5f22012056cfa27706136b4VU', //xseeding
            'email' => 'xseeding@xseeding.nl',
            'type' => 'admin',
            'created' => '2016-05-25 09:02:25',
            'modified' => '2016-05-25 09:02:25',
            'deleted' => null,
            'address_id' => '0a2d28b2-cd01-4a11-afd5-e96d8d7f3ee3'
        ],
        [
            'id' => '5c420372-fcaf-4f4f-ba61-f38253df4f46',
            'username' => 'photex',
            'password' => '$2y$10$JBK87/tveJzabHpc7kcaxuXNqpIBwihGRnnp8s6jTWZh.SC8itldy', //photex
            'genuine' => '968e999ace62ee0f0956c43fe3c2289917d71cc02c86906fa85e517d1946deed', //photex
            'email' => 'photex@photex.nl',
            'type' => 'photex',
            'created' => '2016-05-25 09:02:25',
            'modified' => '2016-05-25 09:02:25',
            'deleted' => null,
            'address_id' => '0a2d28b2-cd01-4a11-afd5-e96d8d7f3ee3'
        ],
        [
            'id' => '91017bf5-5b19-438b-bd44-b0c4e1eaf903',
            'username' => 'person',
            'password' => '$2y$10$JBK87/tveJzabHpc7kcaxuXNqpIBwihGRnnp8s6jTWZh.SC8itldy', //photex
            'genuine' => '968e999ace62ee0f0956c43fe3c2289917d71cc02c86906fa85e517d1946deed', //photex
            'email' => 'person@person.nl',
            'type' => 'person',
            'created' => '2016-05-25 09:02:25',
            'modified' => '2016-05-25 09:02:25',
            'deleted' => null,
            'address_id' => '0a2d28b2-cd01-4a11-afd5-e96d8d7f3ee3'
        ],
    ];
}
