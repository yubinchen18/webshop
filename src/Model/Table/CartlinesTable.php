<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Cartlines Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Carts
 * @property \Cake\ORM\Association\BelongsTo $Photos
 * @property \Cake\ORM\Association\BelongsTo $Products
 * @property \Cake\ORM\Association\HasMany $CartlineProductoptions
 *
 * @method \App\Model\Entity\Cartline get($primaryKey, $options = [])
 * @method \App\Model\Entity\Cartline newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Cartline[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Cartline|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Cartline patchEntity(\Cake\Datasource\
 *          EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Cartline[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Cartline findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CartlinesTable extends Table
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

        $this->table('cartlines');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Carts', [
            'foreignKey' => 'cart_id',
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
        $this->hasMany('CartlineProductoptions', [
            'foreignKey' => 'cartline_id'
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
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        $validator
            ->integer('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmpty('quantity');

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
        $rules->add($rules->existsIn(['photo_id'], 'Photos'));
        $rules->add($rules->existsIn(['product_id'], 'Products'));

        return $rules;
    }
    
    /**
     * Check if user chosen cartline with options already exists or else
     * make new cartline record
     */
    public function checkExistingCartline($cartId, $productId, array $productOptions)
    {
        $cartline = $this->find()
            ->where([
                'cart_id' => $cartId,
                'product_id' => $productId,
                'options_hash' => md5(json_encode($productOptions))
            ])
            ->first();

        // or create new cart
        if (empty($cartline)) {
            $cartline = $this->Carts->Cartlines->newEntity();
        }
        return $cartline;
    }
}
