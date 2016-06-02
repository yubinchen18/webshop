<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Contact Entity.
 *
 * @property string $id
 * @property string $first_name
 * @property int $prefix
 * @property string $last_name
 * @property string $phone
 * @property string $fax
 * @property string $email
 * @property string $gender
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $deleted
 * @property \App\Model\Entity\School[] $schools
 */
class Contact extends Entity
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
        return $this->_properties['first_name'] . '  ' .
                $this->_properties['prefix'] . '  ' .
            $this->_properties['last_name'];
    }
}
