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
            'id' => '4f5cc4c1-2062-45ef-be05-4bcdc324e9da',
            'cartline_id' => 'c78c686e-0302-47cb-8988-d9ce8f0607b1',
            'productoption_choice_id' => 'b1cade53-d878-49cc-94ca-f3a7a6c480c9'
        ],
    ];
}
