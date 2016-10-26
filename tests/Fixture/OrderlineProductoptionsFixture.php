<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrderlineProductoptionsFixture
 *
 */
class OrderlineProductoptionsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'orderline_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'productoption_choice_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'fk_orderline_productoptions_orderlines1_idx' => ['type' => 'index', 'columns' => ['orderline_id'], 'length' => []],
            'fk_orderline_productoptions_productoption_choices1_idx' => ['type' => 'index', 'columns' => ['productoption_choice_id'], 'length' => []],
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
            'id' => '33a549b2-1695-4b6d-974a-a41bf3afa19c',
            'orderline_id' => '9819345b-180f-4ff9-96df-d505ed73fbf9',
            'productoption_choice_id' => 'b94748d3-e573-4e22-8eff-3ebb0118d945'
        ],
    ];
}
