<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PhotosFixture
 *
 */
class PhotosFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'path' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'type' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'barcode_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
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
            'id' => 'a18bfc55-1095-4764-9154-810849a1a664',
            'path' => 'tests/Fixture/photo.jpg',
            'type' => 'portrait',
            'barcode_id' => 'a34c9d93-b89f-4b6d-a10c-8a7e939df834',
            'created' => '2016-06-27 12:53:08',
            'modified' => '2016-06-27 12:53:08',
            'deleted' => null
        ],
        [
            'id' => '123327ea-7e67-48bc-b7f6-49d9d880a356',
            'path' => 'tes2t.jpg',
            'type' => 'portrait',
            'barcode_id' => 'a34c9d93-b89f-4b6d-a10c-8a7e939df834',
            'created' => '2016-06-27 12:53:08',
            'modified' => '2016-06-27 12:53:08',
            'deleted' => null
        ],
        [
            'id' => '277d32ec-b56c-44fa-a10a-ddfcb86c19f8',
            'path' => 'test3.jpg',
            'type' => 'portrait',
            'barcode_id' => 'df99d62f-258c-424d-a1fe-af3213e70867',
            'created' => '2016-06-27 12:53:08',
            'modified' => '2016-06-27 12:53:08',
            'deleted' => null
        ],
        [
            'id' => '59d395fa-e723-43f0-becb-0078425f9a27',
            'path' => 'test4.jpg',
            'type' => 'portrait',
            'barcode_id' => 'df99d62f-258c-424d-a1fe-af3213e70867',
            'created' => '2016-06-27 12:53:08',
            'modified' => '2016-06-27 12:53:08',
            'deleted' => null
        ],
    ];
}
