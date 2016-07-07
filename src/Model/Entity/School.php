<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Text;

/**
 * School Entity.
 *
 * @property string $id
 * @property string $name
 * @property string $slug
 * @property string $contact_id
 * @property \App\Model\Entity\Contact $contact
 * @property string $visitaddress_id
 * @property \App\Model\Entity\Visitaddress $visitaddress
 * @property string $mailaddress_id
 * @property \App\Model\Entity\Mailaddress $mailaddress
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $deleted
 * @property \App\Model\Entity\Project[] $projects
 */
class School extends Entity
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

    protected function _setName($name)
    {
        $this->set('slug', Text::slug($name));
        return $name;
    }
}
