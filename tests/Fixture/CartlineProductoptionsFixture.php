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
            'id' => '23d469b2-ea75-4816-8c6c-8fecdafe2aa3',
            'cartline_id' => '1f7889aa-0179-4a74-8d61-53985019a162',
            'productoption_choice_id' => '52feee84-f086-48dd-a0be-788d0a857c65'
        ],
    ];
}
