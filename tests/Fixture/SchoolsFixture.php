<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SchoolsFixture
 *
 */
class SchoolsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'name' => ['type' => 'string', 'length' => 155, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'slug' => ['type' => 'string', 'length' => 155, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'contact_id' => ['type' => 'uuid', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'visitaddress_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'mailaddress_id' => ['type' => 'uuid', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'deleted' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'slug' => ['type' => 'index', 'columns' => ['slug'], 'length' => []],
            'visitaddress_id' => ['type' => 'index', 'columns' => ['visitaddress_id'], 'length' => []],
            'mailaddress_id' => ['type' => 'index', 'columns' => ['mailaddress_id'], 'length' => []],
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
            'id' => '82199cab-fc52-4853-8f64-575a7721b8e7',
            'name' => 'De ring van putten',
            'slug' => 'de-ring-van-putten',
            'contact_id' => 'b552c2c1-3d94-4734-b974-c15d5e35fe7c',
            'visitaddress_id' => '9e953dd7-fbac-4dc4-9fec-3ca9cd55397e',
            'mailaddress_id' => '8888b43c-68aa-4845-b7d6-6f50f6f7cece',
            'created' => '2016-06-01 14:18:27',
            'modified' => '2016-06-01 14:18:27',
            'deleted' => null
        ],
    ];
}
