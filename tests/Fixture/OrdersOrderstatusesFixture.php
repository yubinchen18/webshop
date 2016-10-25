<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrdersOrderstatusesFixture
 *
 */
class OrdersOrderstatusesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'order_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'orderstatus_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'user_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'deleted' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'fk_orders_orderstatuses_orders1_idx' => ['type' => 'index', 'columns' => ['order_id'], 'length' => []],
            'fk_orders_orderstatuses_orderstatuses1_idx' => ['type' => 'index', 'columns' => ['orderstatus_id'], 'length' => []],
            'fk_orders_orderstatuses_users1_idx' => ['type' => 'index', 'columns' => ['user_id'], 'length' => []],
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
            'id' => '07488ebc-1f00-49f6-adfb-7b8f364ef75f',
            'order_id' => 'ab895192-df43-4e2c-b967-138514cc918a',
            'orderstatus_id' => '4748aa70-5ceb-4db8-af65-c66c421adcd8',
            'user_id' => '1bc81847-37e7-4b19-8dbe-3f2c01a3f04a',
            'created' => '2016-10-25 08:45:00',
            'modified' => '2016-10-25 08:45:00',
            'deleted' => '2016-10-25 08:45:00'
        ],
    ];
}
