<?php
namespace App\Test\Fixture;

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
        'deliveryaddress_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'invoiceaddress_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'totalprice' => ['type' => 'float', 'length' => 9, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'shippingcosts' => ['type' => 'float', 'length' => 9, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'remarks' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'trx_id' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'ideal_status' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'exportstatus' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => 'new', 'collate' => 'utf8_general_ci', 'comment' => 'options:
new
queued
success
cancelled
', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'modified' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'deleted' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'user_id' => ['type' => 'index', 'columns' => ['user_id'], 'length' => []],
            'deliveryaddress_id' => ['type' => 'index', 'columns' => ['deliveryaddress_id'], 'length' => []],
            'invoiceaddress_id' => ['type' => 'index', 'columns' => ['invoiceaddress_id'], 'length' => []],
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
            'id' => 'aaa99b95-4840-4c4e-817b-e2e35027871b',
            'user_id' => 'd95393b6-2365-4c99-8f3b-d2d4d79940f4',
            'deliveryaddress_id' => '31aaa135-806a-493d-baf0-07f739d7b901',
            'invoiceaddress_id' => 'b375d5c1-7b63-4a26-933b-db3a9518294e',
            'totalprice' => 1,
            'shippingcosts' => 1,
            'remarks' => 'Lorem ipsum dolor sit amet',
            'trx_id' => 'Lorem ipsum dolor sit amet',
            'ideal_status' => 'Lorem ipsum dolor sit amet',
            'exportstatus' => 'Lorem ipsum dolor sit amet',
            'created' => 'Lorem ipsum dolor sit amet',
            'modified' => 'Lorem ipsum dolor sit amet',
            'deleted' => 'Lorem ipsum dolor sit amet'
        ],
    ];
}
