<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrderstatusesFixture
 *
 */
class OrderstatusesFixture extends TestFixture
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
        'alias' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'description' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
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
            'id' => '831abe36-21bd-4d30-8d0d-8cb47b74ca5f',
            'name' => 'Nieuwe bestelling',
            'alias' => 'new',
            'description' => 'Bestelling geplaatst',
            'created' => '2016-10-25 08:44:38',
            'modified' => '2016-10-25 08:44:38',
            'deleted' => '2016-10-25 08:44:38'
        ],
        [
            'id' => '962c1818-5ea6-4d23-93bf-1d4684598b76',
            'name' => 'Betaling ontvangen',
            'alias' => 'payment_received',
            'description' => 'De bestelling is betaald',
            'created' => '2016-10-25 08:44:38',
            'modified' => '2016-10-25 08:44:38',
            'deleted' => '2016-10-25 08:44:38'
        ],
    ];
}
