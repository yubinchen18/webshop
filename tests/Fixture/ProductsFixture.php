<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProductsFixture
 *
 */
class ProductsFixture extends TestFixture
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
        'article' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'slug' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'description' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'price_ex' => ['type' => 'float', 'length' => 9, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'vat' => ['type' => 'float', 'length' => 4, 'precision' => 2, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'high_shipping' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'active' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'deleted' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'layout' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => '', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'product_group' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => '', 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
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
            'id' => '3a1bef8f-f977-4a0e-8c29-041961247d2d',
            'name' => 'product1',
            'article' => 'C0001',
            'slug' => 'product-1',
            'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. '
            . 'Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, '
            . 'pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. '
            . 'Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, '
            . 'tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'price_ex' => 9.99,
            'vat' => 1,
            'high_shipping' => 1,
            'active' => 1,
            'created' => '2016-08-22 08:54:02',
            'modified' => '2016-08-22 08:54:02',
            'deleted' => '2016-08-22 08:54:02',
            'layout' => 'CombinationLayout1',
            'product_group' => 'combination-sheets'
        ],
        [
            'id' => '3373b17f-496d-4a57-bbc4-d39f5a2f644a',
            'name' => 'Digitaal alles',
            'article' => 'DPack',
            'slug' => 'dpack',
            'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. '
            . 'Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, '
            . 'pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. '
            . 'Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, '
            . 'tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'price_ex' => 35.00,
            'vat' => 1,
            'high_shipping' => 1,
            'active' => 1,
            'created' => '2016-08-22 08:54:02',
            'modified' => '2016-08-22 08:54:02',
            'deleted' => '2016-08-22 08:54:02',
            'layout' => 'LooseLayout1',
            'product_group' => 'digital'
        ],
        [
            'id' => '5b47630b-fa53-4359-8137-22c8657837b1',
            'name' => 'Gratis Klassenfoto',
            'article' => 'GAF 13x19',
            'slug' => 'gaf-13x-19',
            'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. '
            . 'Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, '
            . 'pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. '
            . 'Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, '
            . 'tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'price_ex' => 0.00,
            'vat' => 1,
            'high_shipping' => 1,
            'active' => 1,
            'created' => '2016-08-22 08:54:02',
            'modified' => '2016-08-22 08:54:02',
            'deleted' => '2016-08-22 08:54:02',
            'layout' => 'LooseLayout1',
            'product_group' => 'loose-prints'
        ],
    ];
}
