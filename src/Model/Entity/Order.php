<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Order Entity
 *
 * @property string $id
 * @property string $user_id
 * @property string $deliveryaddress_id
 * @property string $invoiceaddress_id
 * @property float $totalprice
 * @property float $shippingcosts
 * @property string $remarks
 * @property string $trx_id
 * @property string $ideal_status
 * @property string $exportstatus
 * @property string $created
 * @property string $modified
 * @property string $deleted
 * @property string $ident
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Deliveryaddress $deliveryaddress
 * @property \App\Model\Entity\Invoiceaddress $invoiceaddress
 * @property \App\Model\Entity\Trx $trx
 * @property \App\Model\Entity\Invoice[] $invoices
 * @property \App\Model\Entity\Orderline[] $orderlines
 * @property \App\Model\Entity\PhotexDownload[] $photex_downloads
 * @property \App\Model\Entity\Orderstatus[] $orderstatuses
 */
class Order extends Entity
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
