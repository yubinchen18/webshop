<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PersonsFixture
 *
 */
class PersonsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'group_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'address_id' => ['type' => 'uuid', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'studentnumber' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'firstname' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'prefix' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'lastname' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'slug' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'email' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'type' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'deleted' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'barcode_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'user_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'group_id' => ['type' => 'index', 'columns' => ['group_id'], 'length' => []],
            'user_id' => ['type' => 'index', 'columns' => ['user_id'], 'length' => []],
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
            'id' => '1447e1dd-f3a5-4183-9508-725519b3107d',
            'group_id' => 'e5b778cd-68cd-469f-88b3-37846b984868',
            'address_id' => '9e953dd7-fbac-4dc4-9fec-3ca9cd55397e',
            'studentnumber' => '123456789',
            'firstname' => 'Pieter',
            'prefix' => '',
            'lastname' => 'Vos',
            'slug' => 'pieter-vos',
            'email' => 'pietertje@pietervos.nl',
            'type' => 'student',
            'created' => '2016-06-06 11:47:18',
            'modified' => '2016-06-06 11:47:18',
            'deleted' => null,
            'barcode_id' => 'df99d62f-258c-424d-a1fe-af3213e70867',
            'user_id' => '91017bf5-5b19-438b-bd44-b0c4e1eaf903'
        ],
        [
            'id' => '0fdcdf18-e0a9-43c0-b254-d373eefb79a0',
            'group_id' => '8262ca6b-f23a-4154-afed-fc893c1516d3',
            'address_id' => '8888b43c-68aa-4845-b7d6-6f50f6f7cece',
            'studentnumber' => '98532671',
            'firstname' => 'Henk',
            'prefix' => 'de',
            'lastname' => 'Tank',
            'slug' => 'henk-de-tank',
            'email' => 'henkdetank@test.nl',
            'type' => 'staff',
            'created' => '2016-06-06 11:47:18',
            'modified' => '2016-06-06 11:47:18',
            'deleted' => null,
            'barcode_id' => 'a34c9d93-b89f-4b6d-a10c-8a7e939df834',
            'user_id' => 'e192691b-2e57-4eef-8f8f-fd5d0094716a'
        ],
        [
            'id' => '084acf3a-e474-40a3-9589-41b7a46623ba',
            'group_id' => 'e5b778cd-68cd-469f-88b3-37846b984868',
            'address_id' => '9e953dd7-fbac-4dc4-9fec-3ca9cd55397e',
            'studentnumber' => '987654321',
            'firstname' => 'Jan',
            'prefix' => 'de',
            'lastname' => 'Boer',
            'slug' => 'jan-de-boer',
            'email' => 'jantjedeboer@jandeboer.nl',
            'type' => 'student',
            'created' => '2016-06-06 11:47:18',
            'modified' => '2016-06-06 11:47:18',
            'deleted' => null,
            'barcode_id' => '105ea78c-2e11-4b7f-b42c-05443169d43a',
            'user_id' => '61d2a03c-08f9-400b-9942-9d2f3a843aaa'
        ],
        [
            'id' => 'b23c0370-0900-4f89-ba06-9ecfb48dd51f',
            'group_id' => 'c676d707-4844-4367-a55c-bd070d4e8978',
            'address_id' => '9e953dd7-fbac-4dc4-9fec-3ca9cd55397e',
            'studentnumber' => '987654321',
            'firstname' => 'Adinda',
            'prefix' => 'de',
            'lastname' => 'Fok',
            'slug' => 'adinda-de-fok',
            'email' => 'adinda@xseeding.nl',
            'type' => 'student',
            'created' => '2016-06-06 11:47:18',
            'modified' => '2016-06-06 11:47:18',
            'deleted' => null,
            'barcode_id' => '2f7cce66-df0e-45ae-84f8-ba4c0ca7d4a3',
            'user_id' => '91017bf5-5b19-438b-bd44-b0c4e1eaf903'
        ],
        [
            'id' => '1be6e63a-b0d1-4b39-b141-6228837c633e',
            'group_id' => 'c676d707-4844-4367-a55c-bd070d4e8978',
            'address_id' => '9e953dd7-fbac-4dc4-9fec-3ca9cd55397e',
            'studentnumber' => '987654321',
            'firstname' => 'Adminda',
            'prefix' => 'de',
            'lastname' => 'Fok',
            'slug' => 'adinda-de-fok',
            'email' => 'adinda@xseeding.nl',
            'type' => 'staff',
            'created' => '2016-06-06 11:47:18',
            'modified' => '2016-06-06 11:47:18',
            'deleted' => null,
            'barcode_id' => '2f7cce66-df0e-45ae-84f8-ba4c0ca7d4a3',
            'user_id' => '7f04642a-34a2-4d3d-ae8a-c79e26f5bbfa'
        ],
    ];
}
