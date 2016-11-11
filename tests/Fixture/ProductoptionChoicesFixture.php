<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductoptionChoicesFixture
 *
 */
class ProductoptionChoicesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'productoption_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'value' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'description' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'default2' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'price_ex' => ['type' => 'float', 'length' => 6, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'deleted' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'productoption_id' => ['type' => 'index', 'columns' => ['productoption_id'], 'length' => []],
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
            'id' => 'b6155209-2c1f-46b8-b164-cb5cff20b0d1',
            'productoption_id' => 'd865ed8d-640e-44a2-9828-c12d35df753b',
            'value' => 'sepia',
            'description' => 'Lorem ipsum dolor sit amet',
            'default2' => 1,
            'price_ex' => 1,
            'created' => '2016-10-12 09:55:30',
            'modified' => '2016-10-12 09:55:30',
            'deleted' => null
        ],
        [
            'id' => '6b0fd44a-85a7-4288-8960-9a0f5c981458',
            'productoption_id' => 'd865ed8d-640e-44a2-9828-c12d35df753b',
            'value' => 'geen',
            'description' => 'Lorem ipsum dolor sit amet',
            'default2' => 1,
            'price_ex' => 1,
            'created' => '2016-10-12 09:55:30',
            'modified' => '2016-10-12 09:55:30',
            'deleted' => null
        ],
        [
            'id' => '7c9cf742-9758-4493-9ee6-5015139b814e',
            'productoption_id' => 'ebc439ea-c8f7-4259-8e30-4ad3dda56d1a',
            'value' => 'glans',
            'description' => 'Lorem ipsum dolor sit amet',
            'default2' => 1,
            'price_ex' => 1,
            'created' => '2016-10-12 09:55:30',
            'modified' => '2016-10-12 09:55:30',
            'deleted' => null
        ],
        [
            'id' => '9f426c8c-8e72-4b9a-b8aa-75b2174ebab5',
            'productoption_id' => 'ebc439ea-c8f7-4259-8e30-4ad3dda56d1a',
            'value' => 'mat',
            'description' => 'Lorem ipsum dolor sit amet',
            'default2' => 1,
            'price_ex' => 1,
            'created' => '2016-10-12 09:55:30',
            'modified' => '2016-10-12 09:55:30',
            'deleted' => null
        ],
    ];
}
