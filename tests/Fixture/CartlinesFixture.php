<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CartlinesFixture
 *
 */
class CartlinesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'deleted' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'cart_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'photo_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'product_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'quantity' => ['type' => 'integer', 'length' => 3, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'options_hash' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => '', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'cart_id' => ['type' => 'index', 'columns' => ['cart_id'], 'length' => []],
            'photo_id' => ['type' => 'index', 'columns' => ['photo_id'], 'length' => []],
            'product_id' => ['type' => 'index', 'columns' => ['product_id'], 'length' => []],
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
            'id' => '97e1c06c-7a87-468d-80d2-766a982214de',
            'created' => '2016-10-11 14:01:25',
            'modified' => '2016-10-11 14:01:25',
            'deleted' => '2016-10-11 14:01:25',
            'cart_id' => '1db1f83f-1b45-464b-b239-1e0651ba2710',
            'photo_id' => '59d395fa-e723-43f0-becb-0078425f9a99',
            'product_id' => '3a1bef8f-f977-4a0e-8c29-041961247d2d',
            'quantity' => 5,
            'options_hash' => '3c7000c3dc91896e823fae5253b8d270'
        ],
        [
            'id' => '752a97bc-ab5e-4197-a2da-71c86974b5e0',
            'created' => '2016-10-11 14:01:25',
            'modified' => '2016-10-11 14:01:25',
            'deleted' => '2016-10-11 14:01:25',
            'cart_id' => '08e8339d-fbf6-4078-b73d-af149b3b8141',
            'photo_id' => '59d395fa-e723-43f0-becb-0078425f9a99',
            'product_id' => '3373b17f-496d-4a57-bbc4-d39f5a2f644a',
            'quantity' => 5,
            'options_hash' => '3c7000c3dc91896e823fae5253b8d270'
        ],
    ];
}
