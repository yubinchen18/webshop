<?php
namespace App\Model\Table;

use App\Model\Entity\Person;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * Persons Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Groups
 * @property \Cake\ORM\Association\BelongsTo $Addresses
 * @property \Cake\ORM\Association\BelongsTo $Barcodes
 * @property \Cake\ORM\Association\BelongsTo $Users
 */
class PersonsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('persons');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Deletable');
        
        $this->belongsTo('Groups', [
            'foreignKey' => 'group_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Addresses', [
            'foreignKey' => 'address_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Barcodes', [
            'foreignKey' => 'barcode_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->uuid('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('studentnumber', 'create')
            ->notEmpty('studentnumber');

        $validator
            ->requirePresence('firstname', 'create')
            ->notEmpty('firstname');

        $validator
            ->allowEmpty('prefix');

        $validator
            ->allowEmpty('address_id');

        $validator
            ->requirePresence('lastname', 'create')
            ->notEmpty('lastname');

        $validator
            ->requirePresence('slug', 'create')
            ->notEmpty('slug');

        $validator
            ->email('email')
            ->allowEmpty('email');

        $validator
            ->allowEmpty('type');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['group_id'], 'Groups'));
        $rules->add($rules->existsIn(['barcode_id'], 'Barcodes'));
        return $rules;
    }
    
    public function beforeSave($event, $entity, $options)
    {
        if (empty($entity->barcode)) {
            $entity->barcode = $this->Barcodes->createNewBarcode();
        }
        
        return $entity;
    }

    public function processPersons($data)
    {
        $this->Photos = TableRegistry::get('Photos');
        $existingItem = $this->find()
            ->where(['Persons.id' => $data['id']])
            ->first();

        if (!empty($existingItem)) {
            if ($existingItem->group_id != $data['group_id']) {
                $oldGroup = $this->Groups->find()
                    ->where(['id' => $existingItem->group_id])
                    ->first();

                $newGroup = $this->Groups->find()
                    ->where(['id' => $data['group_id']])
                    ->first();

                if (!empty($oldGroup) && !empty($newGroup)) {
                    $oldPath = APP . "userphotos" . DS . $this->Photos->getPath($data['barcode_id']);
                    $newPath = str_replace(
                        $oldGroup->id . '_' . $oldGroup->slug,
                        $newGroup->id . '_' . $newGroup->slug,
                        $oldPath
                    );

                    if (!file_exists(dirname($newPath))) {
                        mkdir(dirname($newPath), 0777, true);
                        return true;
                    }
                }
            }
        }
        return true;
    }
    
    /**
     *
     * @param Query $query
     * @param array $options
     * @return type
     * @throws \InvalidArgumentException
     */
    public function findSearch(Query $query, array $options)
    {
        if (empty($options['searchTerm'])) {
            throw new \InvalidArgumentException('Missing search term');
        }
        return $query
                ->where(['Persons.lastname LIKE' => "%".$options['searchTerm']."%"])
                ->contain('Groups.Projects.Schools')
                ->limit(6)
                ->order(['Persons.lastname' => 'asc']);
    }
}
