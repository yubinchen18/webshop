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
            'barcode_id' => '0e46688d-02a9-4da4-9f91-ed61a3e7246e'
        ],
        [
            'id' => '8262ca6b-f23a-4154-afed-fc893c1516d3',
            'name' => 'Klas blauw',
            'slug' => 'klas-blauw',
            'created' => '2016-06-06 11:47:13',
            'modified' => '2016-06-06 11:47:13',
            'deleted' => null,
            'project_id' => '4a7d8a96-08f6-441c-a8d5-eb40440e7603',
            'barcode_id' => '88c35f25-886b-48cc-a51c-7959b80c2061'
        ],
        [
            'id' => '0b8c8b9d-3889-4cb5-bdb2-0b31e9979be1',
            'name' => 'Onbekend',
            'slug' => 'onbekend',
            'created' => '2016-06-06 11:47:13',
            'modified' => '2016-06-06 11:47:13',
            'deleted' => null,
            'project_id' => '4a7d8a96-08f6-441c-a8d5-eb40440e7603',
            'barcode_id' => 'b0dacd2c-ffd5-4af7-b69f-fc12e009b256'
        ],
        [
            'id' => 'af83fdb0-c76c-4643-913c-e74f318026d7',
            'name' => 'Nieuwe group',
            'slug' => 'nieuwe-groep',
            'created' => '2016-06-06 11:47:13',
            'modified' => '2016-06-06 11:47:13',
            'deleted' => null,
            'project_id' => '4a7d8a96-08f6-441c-a8d5-eb40440e7603',
            'barcode_id' => 'a34c9d93-b89f-4b6d-a10c-8a7e939df834'
        ],
        [
            'id' => 'c676d707-4844-4367-a55c-bd070d4e8978',
            'name' => 'groep 8B',
            'slug' => 'groep-8b',
            'created' => '2016-06-06 11:47:13',
            'modified' => '2016-06-06 11:47:13',
            'deleted' => null,
            'project_id' => '4a7d8a96-08f6-441c-a8d5-eb40440e7603',
            'barcode_id' => '6844d1e7-d6b2-4e23-8bbe-d671b698d1c3'
        ],

    ];
}
