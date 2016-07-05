<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DownloadqueuesFixture
 *
 */
class DownloadqueuesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'profile_name' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'model' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'foreign_key' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
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
            'id' => 'c7872eea-eb05-4bcf-8a16-0233a7f12e7a',
            'profile_name' => 'photographer',
            'model' => 'Schools',
            'foreign_key' => '82199cab-fc52-4853-8f64-575a7721b8e7',
            'created' => '2016-06-27 09:22:26',
            'modified' => '2016-06-27 09:22:26',
            'deleted' => null
        ],
        [
            'id' => '97acd799-7a3f-4bae-af70-ec70d7e8d4b7',
            'profile_name' => 'photographer',
            'model' => 'Users',
            'foreign_key' => 'ed2438e7-f8e4-472a-a6de-48d763c29ed8',
            'created' => '2016-06-27 09:22:26',
            'modified' => '2016-06-27 09:22:26',
            'deleted' => null
        ],
        [
            'id' => '62beb0e3-ef13-458a-8973-67aabbf101d0',
            'profile_name' => 'photographer',
            'model' => 'Barcodes',
            'foreign_key' => 'cb7f7c7d-fafb-452e-9b2d-e156f90f6209',
            'created' => '2016-06-27 09:22:26',
            'modified' => '2016-06-27 09:22:26',
            'deleted' => null
        ],
        [
            'id' => 'fb7d9668-c2a2-4be0-9d04-3dc236d9fd2d',
            'profile_name' => 'photographer',
            'model' => 'Projects',
            'foreign_key' => '4a7d8a96-08f6-441c-a8d5-eb40440e7603',
            'created' => '2016-06-27 09:22:26',
            'modified' => '2016-06-27 09:22:26',
            'deleted' => null
        ],
        [
            'id' => '97a9f95d-7212-42f9-bb2c-3d0c20b7808d',
            'profile_name' => 'photographer',
            'model' => 'Groups',
            'foreign_key' => 'e5b778cd-68cd-469f-88b3-37846b984868',
            'created' => '2016-06-27 09:22:26',
            'modified' => '2016-06-27 09:22:26',
            'deleted' => null
        ],
        [
            'id' => '442800b8-a449-4a1e-b539-ce8cf79f9099',
            'profile_name' => 'photographer',
            'model' => 'Persons',
            'foreign_key' => '1447e1dd-f3a5-4183-9508-725519b3107d',
            'created' => '2016-06-27 09:22:26',
            'modified' => '2016-06-27 09:22:26',
            'deleted' => null
        ],
    ];
}
