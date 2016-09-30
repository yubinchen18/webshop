<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Utility\Security;
use Cake\Core\Configure;

/**
 * User Entity.
 *
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $real_pass
 * @property string $email
 * @property string $type
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $deleted
 * @property string $address_id
 * @property \App\Model\Entity\Address $address
 * @property \App\Model\Entity\Order[] $orders
 * @property \App\Model\Entity\OrdersOrderstatus[] $orders_orderstatuses
 * @property \App\Model\Entity\Person[] $persons
 */
class User extends Entity
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
        'id' => false,
    ];

    /**
     * Fields that are excluded from JSON an array versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
        'genuine'
    ];
    
    protected function _setPassword($password)
    {
        return (new DefaultPasswordHasher)->hash($password);
    }

    protected function _setGenuine($password)
    {
        $key = Configure::read('EncryptionSalt');
        $password = Security::encrypt($password, $key);
        return $password;
    }
}
