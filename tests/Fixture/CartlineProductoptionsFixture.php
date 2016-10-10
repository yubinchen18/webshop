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
            'id' => '0b180a33-29c5-4c01-8160-ac9796a749fc',
            'cartline_id' => '243a0ffc-97eb-443b-a825-9856743f48cf',
            'productoption_choice_id' => '48260345-9491-4b1c-a729-cf706723a3ab'
        ],
    ];
}
