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
class PersonsTable extends BaseTable
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
        $this->displayField('full_name');
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
        
        $this->hasMany('Coupons');
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
    
    public function beforeRules($event, $entity, $options)
    {
        if (empty($entity->barcode) && empty($entity->barcode_id)) {
            $entity->barcode_id = $this->Barcodes->createNewBarcode()->id;
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
                    $oldPath = $this->Photos->getPath($data['barcode_id']);
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
    
    public function findPersons(Query $query, array $options)
    {
        if (empty($options['userids']) || !is_array($options['userids'])) {
            throw new \InvalidArgumentException('Missing user ids');
        }
        
        $query->where(['Persons.user_id IN' => $options['userids']]);
        
        if (!empty($options['contains'])) {
            $query->contain($options['contains']);
        }
        
        return $query;
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
        
        $searchTerms = explode(' ', $options['searchTerm']);
        
        foreach($searchTerms as $term) {
            $query->andWhere(['OR' => [
                                'Persons.firstname LIKE' => "%".$term."%",
                                'Persons.lastname LIKE' => "%".$term."%"]
                            ]);
        }
        
        return $query->contain('Groups.Projects.Schools')
                ->limit(12)
                ->order(['Persons.lastname' => 'asc']);
        
    }
    
    public function findForGroup(Query $query, array $options)
    {
        if (empty($options['groupId'])) {
            throw new \InvalidArgumentException('Missing group id');
        }
        
        return $query
                ->where(['Persons.group_id' => $options['groupId']]);
    }
}
