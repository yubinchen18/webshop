<?php
namespace App\Model\Table;

use App\Model\Entity\Group;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Groups Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Projects
 * @property \Cake\ORM\Association\BelongsTo $Barcodes
 * @property \Cake\ORM\Association\HasMany $Persons
 */
class GroupsTable extends BaseTable
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

        $this->table('groups');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Deletable');
        
        $this->belongsTo('Projects', [
            'foreignKey' => 'project_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Barcodes', [
            'foreignKey' => 'barcode_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Persons', [
            'foreignKey' => 'group_id'
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
            ->notEmpty('name')
            ->add('name', 'custom', [
                'rule' => function ($value, $context) {
                    if ($this->exists(['name' => $value, 'project_id' => $context['data']['project_id']])) {
                        return false;
                    }
                    
                    return true;
                },
                'message' => 'Er bestaat al een klas met deze naam voor het gekozen project'
            ]);

        $validator
            ->allowEmpty('slug');
        
        $validator
            ->allowEmpty('project_id');

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
        $rules->add($rules->existsIn(['project_id'], 'Projects'));
        $rules->add($rules->existsIn(['barcode_id'], 'Barcodes'));
        return $rules;
    }

    public function beforeSave($event, $entity, $options)
    {
        if (empty($entity->barcode) && empty($entity->barcode_id)) {
            $entity->barcode = $this->Barcodes->createNewBarcode('', 'group');
        }
        
        return $entity;
    }
    
    public function checkGroups($object)
    {
        $existingGroup = $this->find()
                ->where([
                    'Groups.project_id' => $object['Groups']['project_id'],
                    'Groups.name' => 'Onbekend'])
                ->first();

        if (!empty($existingGroup)) {
            $data = [
                'BarcodeId' => $existingGroup->barcode_id,
                'GroupId' => $existingGroup->id
            ];

            return $data;
        }
        
        return false;
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
                ->where(['Groups.name LIKE' => "%".$options['searchTerm']."%"])
                ->contain('Projects.Schools')
                ->limit(6)
                ->order(['Groups.name' => 'asc']);
    }
}
