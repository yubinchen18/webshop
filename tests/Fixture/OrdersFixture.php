<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrdersFixture
 *
 */
class OrdersFixture extends TestFixture
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
        'ident' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => '', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
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
            'id' => '9861815c-edaa-4ce3-b914-09a13d9fc99e',
            'user_id' => 'c4b06162-5bfa-4f1c-af86-694ddecd24a2',
            'deliveryaddress_id' => 'a573506c-d35d-4aee-8feb-7f3546fb6f48',
            'invoiceaddress_id' => 'ce9bf008-b23f-4144-ab23-4e98c78afede',
            'totalprice' => 1,
            'shippingcosts' => 1,
            'remarks' => 'Lorem ipsum dolor sit amet',
            'trx_id' => 'Lorem ipsum dolor sit amet',
            'ideal_status' => 'Lorem ipsum dolor sit amet',
            'exportstatus' => 'Lorem ipsum dolor sit amet',
            'created' => 'Lorem ipsum dolor sit amet',
            'modified' => 'Lorem ipsum dolor sit amet',
            'deleted' => 'Lorem ipsum dolor sit amet',
            'ident' => 'Lorem ipsum dolor sit amet'
        ],
    ];
}
