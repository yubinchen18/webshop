<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Person Entity.
 *
 * @property string $id
 * @property string $group_id
 * @property \App\Model\Entity\Group $group
 * @property string $address_id
 * @property \App\Model\Entity\Address $address
 * @property string $studentnumber
 * @property string $firstname
 * @property string $prefix
 * @property string $lastname
 * @property string $slug
 * @property string $email
 * @property string $type
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $deleted
 * @property string $barcode_id
 * @property \App\Model\Entity\Barcode $barcode
 * @property string $user_id
 * @property \App\Model\Entity\User $user
 */
class Person extends Entity
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

    protected function _getFullName()
    {
        if (isset($this->_properties['firstname']) &&
                isset($this->_properties['prefix']) &&
                isset($this->_properties['lastname'])) {
            return $this->_properties['firstname'] . '  ' .
                $this->_properties['prefix'] . '  ' .
                $this->_properties['lastname'];
        }
    }
}
