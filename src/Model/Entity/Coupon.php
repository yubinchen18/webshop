<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Coupon Entity
 *
 * @property string $id
 * @property string $coupon_code
 * @property string $person_id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $deleted
 */
class Coupon extends Entity
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
    
    public function isValidCoupon($persons)
    {
        if (is_null($this->person_id)) {
            return true;
        }
        
        foreach ($persons as $person) {
            foreach ($person->coupons as $coupon)
            {
                if ($coupon->coupon_code === $this->coupon_code) {
                    return true;
                }
            }
        }
        
        return false;
    }
    
    public function isCouponInCart($cart)
    {
        foreach ($cart->cart_coupons as $coupon) {
            if ($coupon->coupon->processed == 1) {
                return true;
            }
        }
        
        return false;
    }
    
    public function canUseCoupon($cart)
    {
        switch($this->type)
        {
            case 'product':
                return $cart->hasProduct($this->typedata);
            default:
                return false;
        }
        
        return false;
    }
}
