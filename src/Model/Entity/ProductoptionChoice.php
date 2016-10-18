<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductoptionChoice Entity
 *
 * @property string $id
 * @property string $productoption_id
 * @property string $value
 * @property string $description
 * @property bool $default
 * @property float $price_ex
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $deleted
 *
 * @property \App\Model\Entity\Productoption $productoption
 * @property \App\Model\Entity\CartlineProductoption[] $cartline_productoptions
 * @property \App\Model\Entity\OrderlineProductoption[] $orderline_productoptions
 */
class ProductoptionChoice extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
