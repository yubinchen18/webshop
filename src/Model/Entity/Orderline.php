<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Orderline Entity
 *
 * @property string $id
 * @property string $article
 * @property string $productname
 * @property int $quantity
 * @property float $price_ex
 * @property float $vat
 * @property bool $exported
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $deleted
 * @property string $order_id
 * @property string $photo_id
 * @property string $product_id
 *
 * @property \App\Model\Entity\Order $order
 * @property \App\Model\Entity\Photo $photo
 * @property \App\Model\Entity\Product $product
 * @property \App\Model\Entity\OrderlineProductoption[] $orderline_productoptions
 */
class Orderline extends Entity
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
