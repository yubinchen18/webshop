<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * GroupsFixture
 *
 */
class GroupsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'name' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'slug' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'deleted' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'project_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'barcode_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'project_id' => ['type' => 'index', 'columns' => ['project_id'], 'length' => []],
            'barcode_id' => ['type' => 'index', 'columns' => ['barcode_id'], 'length' => []],
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
            'id' => 'e5b778cd-68cd-469f-88b3-37846b984868',
            'name' => 'Klas 2A',
            'slug' => 'klas-2a',
            'created' => '2016-06-06 11:47:13',
            'modified' => '2016-06-06 11:47:13',
            'deleted' => null,
            'project_id' => '4a7d8a96-08f6-441c-a8d5-eb40440e7603',
            'barcode_id' => 'c78338d8-b286-4b9e-8486-6bd3de3be695'
        ],
        [
            'id' => '8262ca6b-f23a-4154-afed-fc893c1516d3',
            'name' => 'Klas blauw',
            'slug' => 'klas-blauw',
            'created' => '2016-06-06 11:47:13',
            'modified' => '2016-06-06 11:47:13',
            'deleted' => null,
            'project_id' => '4a7d8a96-08f6-441c-a8d5-eb40440e7603',
            'barcode_id' => 'c5571a8d-bc26-4c42-ae64-a9fd5fc0c799'
        ],
    ];
}
