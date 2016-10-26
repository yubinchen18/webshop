<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Orderstatuses Model
 *
 * @property \Cake\ORM\Association\BelongsToMany $Orders
 *
 * @method \App\Model\Entity\Orderstatus get($primaryKey, $options = [])
 * @method \App\Model\Entity\Orderstatus newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Orderstatus[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Orderstatus|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Orderstatus patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Orderstatus[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Orderstatus findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrderstatusesTable extends Table
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

        $this->table('orderstatuses');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('OrdersOrderstatuses', [
            'foreignKey' => 'orderstatus_id',
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->allowEmpty('description');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }
    
    public function findByAlias($query, $options = [])
    {
        if(empty($options['alias'])) {
            return false;
        }
        
        return $this->find()
                ->where(['alias' => $options['alias']]);
        
    }
}
