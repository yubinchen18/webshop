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
        'order_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'created' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'modified' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'deleted' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
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
            'order_id' => '9861815c-edaa-4ce3-b914-09a13d9fc99e',
            'created' => 'Lorem ipsum dolor sit amet',
            'modified' => 'Lorem ipsum dolor sit amet',
            'deleted' => 'Lorem ipsum dolor sit amet'
        ],
        [
            'id' => '08e8339d-fbf6-4078-b73d-af149b3b8141',
            'user_id' => '61d2a03c-08f9-400b-9942-9d2f3a843aaa',
            'order_id' => '79ac1071-1940-4513-9faf-f57893ca3ade',
            'created' => 'Lorem ipsum dolor sit amet',
            'modified' => 'Lorem ipsum dolor sit amet',
            'deleted' => 'Lorem ipsum dolor sit amet'
        ],
        
    ];
}
