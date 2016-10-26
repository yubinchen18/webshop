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
 * @property \Cake\ORM\Association\HasMany $Cartlines
 *
 * @method \App\Model\Entity\Cart get($primaryKey, $options = [])
 * @method \App\Model\Entity\Cart newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Cart[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Cart|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Cart patchEntity(\Cake\Datasource\
 *          EntityInterface $entity, array $data, array $options = [])
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
        $this->hasOne('Carts', [
            'foreignKey' => 'cart_id',
            'joinType' => 'LEFT'
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

        return $rules;
    }
    
    public function findByUserid($query, $options = [])
    {
        if(empty($options['user_id'])) {
            return false;
        }
        
        return $this->find()->where([
               'Carts.user_id' => $options['user_id'],
               'Carts.order_id IS NULL'
            ])
           ->contain([
               'Cartlines' => function($q) {
                   return $q->order(['Cartlines.created'])
                           ->contain([
                               'CartlineProductoptions.ProductoptionChoices.Productoptions'
                           ]);
               },
               'Cartlines.Photos',
               'Cartlines.Products'
           ]);
    }
    
    /**
     * Check if user already has a cart or else
     * make new cart
     * @param type $userId
     * @return boolean
     */
    public function checkExistingCart($userId)
    {
        $cart = $this->find('byUserid', ['user_id' => $userId])->first();
            
        if (empty($cart)) {
            $cart = $this->newEntity(['user_id' => $userId]);
            
            if (!$this->save($cart)) {
                return false;
            }
        }
        return $cart;
    }
    
    public function getCartTotals($cart_id)
    {
        $cart = $this->get($cart_id,[
            'contain' => [
                'Cartlines.Products'
            ]
        ]);
        
        $totals = [
            'products' => 0,
            'discount' => 0,
            'tax' => 0,
            'shippingcosts' => 3.95
        ];
        
        $total_lines = 0;
        $high_shipping = false;
        foreach($cart->cartlines as $line) {
            $total_lines++;
            
            // Calculate line price
            $subtotal = $line->product->price_ex * $line->quantity;
            $discount = 0;
            if($line->product->has_discount === 1) {
                $subtotal = $line->product->price_ex;
                for($n=2;$n<=$line->quantity;$n++) {
                    $subtotal += 3.78;
                    $discount += ($line->product->price_ex - 3.78);
                }
            }
            
            $totals['products'] += $subtotal;
            $totals['discount'] += $discount;
            
            if(!empty($line->product->high_shipping)) {
                $high_shipping = true;
            }
        }
        
        if($total_lines > 2) {
            $totals['shippingcosts'] = 0;
        }
        if($high_shipping) {
            $totals['shippingcosts'] = 12.50;
        }
        return $totals;
        
    }
}
