<?php
namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Addresses
 * @property \Cake\ORM\Association\HasMany $Orders
 * @property \Cake\ORM\Association\HasMany $OrdersOrderstatuses
 * @property \Cake\ORM\Association\HasMany $Persons
 */
class UsersTable extends Table
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

        $this->table('users');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Deletable');
        
        $this->belongsTo('Addresses', [
            'foreignKey' => 'address_id'
        ]);
        $this->hasMany('Orders', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('OrdersOrderstatuses', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Persons', [
            'foreignKey' => 'user_id'
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
            ->requirePresence('username', 'create')
            ->notEmpty('username');

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password');

        $validator
            ->requirePresence('genuine', 'create')
            ->notEmpty('genuine');

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
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->isUnique(['email']));
        return $rules;
    }

    /**
     *
     * @param Query $query
     * @param array $options
     * @return Query
     */
    public function findBasicAuthUsers(Query $query, array $options)
    {
        $query->where(['type' => 'photographer'])
        ->orWhere([
            'username' => $options['username'],
            'type' => 'admin']);
        return $query;
    }

    /**
     *
     * @param Query $query
     * @param array $options
     * @return Query
     */
    public function findBasicAuthUser(Query $query, array $options)
    {
        $query->where(['type' => 'photographer']);

        return $query;
    }
}
