<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CartlineProductoptionsFixture
 *
 */
class CartlineProductoptionsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'cartline_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'productoption_choice_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'cartline_id' => ['type' => 'index', 'columns' => ['cartline_id'], 'length' => []],
            'productoption_choice_id' => ['type' => 'index', 'columns' => ['productoption_choice_id'], 'length' => []],
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
            'id' => '25df3480-f3e9-44c5-a22a-9feb8ba6db6c',
            'cartline_id' => '97e1c06c-7a87-468d-80d2-766a982214de',
            'productoption_choice_id' => '7c9cf742-9758-4493-9ee6-5015139b814e'
        ],
        [
            'id' => '23d469b2-ea75-4816-8c6c-8fecdafe2aa3',
            'cartline_id' => '97e1c06c-7a87-468d-80d2-766a982214de',
            'productoption_choice_id' => 'b6155209-2c1f-46b8-b164-cb5cff20b0d1'
        ],
        [
            'id' => '23d469b2-ea75-4816-8c6c-8fecdafe2aa2',
            'cartline_id' => '752a97bc-ab5e-4197-a2da-71c86974b5e0',
            'productoption_choice_id' => 'd865ed8d-640e-44a2-9828-c12d35df753b'
        ],
    ];
}
