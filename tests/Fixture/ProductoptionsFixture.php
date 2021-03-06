<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductoptionsFixture
 *
 */
class ProductoptionsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'name' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
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
            'id' => 'd865ed8d-640e-44a2-9828-c12d35df753b',
            'name' => 'Kleurbewerking',
            'created' => '2016-10-04 12:04:24',
            'modified' => '2016-10-04 12:04:24',
            'deleted' => null
        ],
        [
            'id' => 'ebc439ea-c8f7-4259-8e30-4ad3dda56d1a',
            'name' => 'Uitvoering',
            'created' => '2016-10-04 12:04:24',
            'modified' => '2016-10-04 12:04:24',
            'deleted' => null
        ],
        [
            'id' => 'ebc439ea-c8f7-4259-8e30-4ad3dda56d1b',
            'name' => 'geen',
            'created' => '2016-10-04 12:04:24',
            'modified' => '2016-10-04 12:04:24',
            'deleted' => null
        ]
    ];
}
