<?php
namespace App\Model\Table;

use App\Model\Entity\School;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Hash;
use Cake\ORM\TableRegistry;

/**
 * Schools Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Contacts
 * @property \Cake\ORM\Association\BelongsTo $Visitaddresses
 * @property \Cake\ORM\Association\BelongsTo $Mailaddresses
 * @property \Cake\ORM\Association\HasMany $Projects
 */
class BaseTable extends Table
{
    private $Downloadqueues;

    public function initialize(array $config) {
        parent::initialize($config);
        
        $this->Downloadqueues = TableRegistry::get('Downloadqueues');
    }
    
    public function afterSave($event, $entity, $options)
    {
        $queueModels = [
            'Schools',
            'Projects',
            'Groups',
            'Persons',
            'Barcodes'
        ];
        
        if(!in_array($this->registryAlias(),$queueModels)) {
            return true;
        }
        if(!empty($options['api_user'])) {
            return $this->Downloadqueues->addDownloadQueueItem($this->registryAlias(),$entity->id, $options['api_user']);
        }
        
        return $this->Downloadqueues->addDownloadQueueItem($this->registryAlias(),$entity->id);
    }
    
}

