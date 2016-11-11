<?php namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CartsFixture
 *
 */
class CartsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'user_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'order_id' => ['type' => 'uuid', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'deleted' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
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
            'id' => '1db1f83f-1b45-464b-b239-1e0651ba2710',
            'user_id' => 'c4b06162-5bfa-4f1c-af86-694ddecd24a2',
            'order_id' => null,
            'created' => '2016-06-01 14:14:01',
            'modified' => '2016-06-01 14:14:01',
            'deleted' => null
        ],
        [
            'id' => '08e8339d-fbf6-4078-b73d-af149b3b8141',
            'user_id' => '61d2a03c-08f9-400b-9942-9d2f3a843aaa',
            'order_id' => null,
            'created' => '2016-06-01 14:14:01',
            'modified' => '2016-06-01 14:14:01',
            'deleted' => null
        ],
        
    ];
}
