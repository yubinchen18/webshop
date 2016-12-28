<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CartCoupons Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Carts
 * @property \Cake\ORM\Association\BelongsTo $Coupons
 *
 * @method \App\Model\Entity\CartCoupon get($primaryKey, $options = [])
 * @method \App\Model\Entity\CartCoupon newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CartCoupon[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CartCoupon|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CartCoupon patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CartCoupon[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CartCoupon findOrCreate($search, callable $callback = null)
 */
class CartCouponsTable extends Table
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

        $this->table('cart_coupons');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Carts', [
            'foreignKey' => 'cart_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Coupons', [
            'foreignKey' => 'coupon_id',
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
            ->notEmpty('cart_id');
        
        $validator
            ->notEmpty('coupon_id');

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
        $rules->add($rules->existsIn(['cart_id'], 'Carts'));
        $rules->add($rules->existsIn(['coupon_id'], 'Coupons'));

        return $rules;
    }
}
