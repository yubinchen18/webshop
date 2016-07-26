<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BarcodesFixture
 *
 */
class BarcodesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'barcode' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'type' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
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
            'id' => '0e46688d-02a9-4da4-9f91-ed61a3e7246e',
            'barcode' => '1111',
            'type' => 'barcode',
            'created' => '2016-06-06 13:58:07',
            'modified' => '2016-06-06 13:58:07',
            'deleted' => null
        ],
        [
            'id' => '88c35f25-886b-48cc-a51c-7959b80c2061',
            'barcode' => '2222',
            'type' => 'barcode',
            'created' => '2016-06-06 13:58:07',
            'modified' => '2016-06-06 13:58:07',
            'deleted' => null
        ],
        [
            'id' => 'df99d62f-258c-424d-a1fe-af3213e70867',
            'barcode' => '3333',
            'type' => 'person',
            'created' => '2016-06-06 13:58:07',
            'modified' => '2016-06-06 13:58:07',
            'deleted' => null
        ],
        [
            'id' => 'cb7f7c7d-fafb-452e-9b2d-e156f90f6209',
            'barcode' => '4444',
            'type' => 'barcode',
            'created' => '2016-06-06 13:58:07',
            'modified' => '2016-06-06 13:58:07',
            'deleted' => null
        ],
        [
            'id' => 'b0dacd2c-ffd5-4af7-b69f-fc12e009b256',
            'barcode' => '5555',
            'type' => 'barcode',
            'created' => '2016-06-06 13:58:07',
            'modified' => '2016-06-06 13:58:07',
            'deleted' => null
        ],
        [
            'id' => 'a34c9d93-b89f-4b6d-a10c-8a7e939df834',
            'barcode' => '5555',
            'type' => 'group',
            'created' => '2016-06-06 13:58:07',
            'modified' => '2016-06-06 13:58:07',
            'deleted' => null
        ],
        [
            'id' => 'ba0f3313-757a-430a-bda3-908082dea691',
            'barcode' => '5555',
            'type' => 'person',
            'created' => '2016-06-06 13:58:07',
            'modified' => '2016-06-06 13:58:07',
            'deleted' => null
        ]

    ];
}
