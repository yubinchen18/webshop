<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Cartline Entity
 *
 * @property string $id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $deleted
 * @property string $cart_id
 * @property string $photo_id
 * @property string $product_id
 * @property int $quantity
 *
 * @property \App\Model\Entity\Cart $cart
 * @property \App\Model\Entity\Photo $photo
 * @property \App\Model\Entity\Product $product
 * @property \App\Model\Entity\CartlineProductoption[] $cartline_productoptions
 */
class Cartline extends Entity
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
