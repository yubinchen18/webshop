<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Address Entity.
 *
 * @property string $id
 * @property string $street
 * @property int $number
 * @property string $extension
 * @property string $zipcode
 * @property string $city
 * @property string $gender
 * @property string $firstname
 * @property string $prefix
 * @property string $lastname
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $deleted
 * @property \App\Model\Entity\Invoice[] $invoices
 * @property \App\Model\Entity\Person[] $persons
 * @property \App\Model\Entity\User[] $users
 */
class Address extends Entity
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
        return $this->_properties['firstname'] . '  ' .
                $this->_properties['prefix'] . '  ' .
            $this->_properties['lastname'];
    }
    
    protected function _getFullAddress()
    {
        return $this->_properties['street'] . '  ' .
                $this->_properties['number'] . ' ' .
                $this->_properties['extension'];
    }
}
