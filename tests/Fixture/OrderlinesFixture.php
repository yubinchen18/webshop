<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrderlinesFixture
 *
 */
class OrderlinesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'article' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'productname' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'quantity' => ['type' => 'integer', 'length' => 3, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'price_ex' => ['type' => 'float', 'length' => 9, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'vat' => ['type' => 'float', 'length' => 4, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'exported' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'deleted' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'order_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'photo_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'product_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'fk_orderlines_orders1_idx' => ['type' => 'index', 'columns' => ['order_id'], 'length' => []],
            'fk_orderlines_photos1_idx' => ['type' => 'index', 'columns' => ['photo_id'], 'length' => []],
            'fk_orderlines_products1_idx' => ['type' => 'index', 'columns' => ['product_id'], 'length' => []],
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
            'id' => '05c4ea59-4da6-4353-b7c3-31b4d424e9a4',
            'article' => 'Lorem ipsum dolor sit amet',
            'productname' => 'Lorem ipsum dolor sit amet',
            'quantity' => 1,
            'price_ex' => 1,
            'vat' => 1,
            'exported' => 1,
            'created' => '2016-10-25 06:59:29',
            'modified' => '2016-10-25 06:59:29',
            'deleted' => '2016-10-25 06:59:29',
            'order_id' => '9861815c-edaa-4ce3-b914-09a13d9fc99e',
            'photo_id' => '9f8d29d0-5563-4b03-809b-0e92c4be8f5f',
            'product_id' => '3a1bef8f-f977-4a0e-8c29-041961247d2d'
        ],
        [
            'id' => '9aa3b117-8430-45de-9d18-22c25722bc96',
            'article' => 'DPack',
            'productname' => 'DIGITAAL ALLES',
            'quantity' => 1,
            'price_ex' => 1,
            'vat' => 1,
            'exported' => 1,
            'created' => '2016-10-25 06:59:29',
            'modified' => '2016-10-25 06:59:29',
            'deleted' => '2016-10-25 06:59:29',
            'order_id' => '79ac1071-1940-4513-9faf-f57893ca3ade',
            'photo_id' => '9f8d29d0-5563-4b03-809b-0e92c4be8f5f',
            'product_id' => '3373b17f-496d-4a57-bbc4-d39f5a2f644a'
        ],
    ];
}
