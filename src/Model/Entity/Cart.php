<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Cart Entity
 *
 * @property string $id
 * @property string $user_id
 * @property string $created
 * @property string $modified
 * @property string $deleted
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Cartline[] $cartlines
 */
class Cart extends Entity
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
    
    public function hasProduct($productId)
    {
        foreach ($this->cartlines as $cartline) {
            if ($cartline->product->id === $productId) {
                pr($productId);
                return true;
            }
            
            return false;
        }
    }
}
