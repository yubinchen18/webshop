<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Orderlines Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Orders
 * @property \Cake\ORM\Association\BelongsTo $Photos
 * @property \Cake\ORM\Association\BelongsTo $Products
 * @property \Cake\ORM\Association\HasMany $OrderlineProductoptions
 *
 * @method \App\Model\Entity\Orderline get($primaryKey, $options = [])
 * @method \App\Model\Entity\Orderline newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Orderline[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Orderline|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Orderline patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Orderline[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Orderline findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrderlinesTable extends Table
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

        $this->table('orderlines');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Photos', [
            'foreignKey' => 'photo_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('OrderlineProductoptions', [
            'foreignKey' => 'orderline_id'
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
            ->allowEmpty('article');

        $validator
            ->requirePresence('productname', 'create')
            ->notEmpty('productname');

        $validator
            ->integer('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmpty('quantity');

        $validator
            ->numeric('price_ex')
            ->requirePresence('price_ex', 'create')
            ->notEmpty('price_ex');

        $validator
            ->numeric('vat')
            ->requirePresence('vat', 'create')
            ->notEmpty('vat');

        $validator
            ->boolean('exported')
            ->requirePresence('exported', 'create')
            ->notEmpty('exported');

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
        $rules->add($rules->existsIn(['order_id'], 'Orders'));
        $rules->add($rules->existsIn(['photo_id'], 'Photos'));
        $rules->add($rules->existsIn(['product_id'], 'Products'));

        return $rules;
    }

    /**
     * Returns the database connection name to use by default.
     *
     * @return string
     */
    public static function defaultConnectionName()
    {
        return 'development';
    }
}
