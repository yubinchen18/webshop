<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Carts Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Deliveryaddresses
 * @property \Cake\ORM\Association\BelongsTo $Invoiceaddresses
 * @property \Cake\ORM\Association\BelongsTo $Trxes
 * @property \Cake\ORM\Association\HasMany $Cartlines
 *
 * @method \App\Model\Entity\Cart get($primaryKey, $options = [])
 * @method \App\Model\Entity\Cart newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Cart[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Cart|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Cart patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Cart[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Cart findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CartsTable extends Table
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

        $this->table('carts');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Deliveryaddresses', [
            'foreignKey' => 'deliveryaddress_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Invoiceaddresses', [
            'foreignKey' => 'invoiceaddress_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Trxes', [
            'foreignKey' => 'trx_id'
        ]);
        $this->hasMany('Cartlines', [
            'foreignKey' => 'cart_id'
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
            ->numeric('totalprice')
            ->requirePresence('totalprice', 'create')
            ->notEmpty('totalprice');

        $validator
            ->numeric('shippingcosts')
            ->requirePresence('shippingcosts', 'create')
            ->notEmpty('shippingcosts');

        $validator
            ->requirePresence('remarks', 'create')
            ->notEmpty('remarks');

        $validator
            ->allowEmpty('ideal_status');

        $validator
            ->allowEmpty('exportstatus');

        $validator
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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['deliveryaddress_id'], 'Deliveryaddresses'));
        $rules->add($rules->existsIn(['invoiceaddress_id'], 'Invoiceaddresses'));
        $rules->add($rules->existsIn(['trx_id'], 'Trxes'));

        return $rules;
    }
}
