<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Hash;
use Cake\Core\Configure;

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
        $this->hasOne('Orders', [
            'foreignKey' => 'order_id',
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
        if (empty($options['user_id'])) {
            return false;
        }
        
        return $this->find()->where([
               'Carts.user_id' => $options['user_id'],
               'Carts.order_id IS NULL'
            ])
           ->contain([
               'Cartlines' => function ($q) {
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
    
    public function updatePrices($cart_id)
    {
        $cart = $this->get($cart_id, [
            'contain' => [
                'Cartlines' => function ($q) {
                    return $q
                        ->orderAsc('Cartlines.created')
                        ->contain('Products');
                },
             'Cartlines.Photos.Barcodes.Persons'
        ]
        ]);
        $users = array_unique(Hash::extract($cart, "cartlines.{n}.photo.barcode.person.user_id"));
        $userDiscounts = array_map(function () {
        }, array_flip($users));
        $userDigitalLines = array_map(function () {
        }, array_flip($users));
        $total_lines = 0;
        $discount = 0;
        $high_shipping = false;
         
        foreach ($cart->cartlines as $cartline) {
            $total_lines++;
            $user = isset($cartline->photo->barcode->person->user_id) ? $cartline->photo->barcode->person->user_id : '';
            $subtotal = $cartline->quantity * $cartline->product->price_ex;
             
            if ($cartline->product->has_discount == 1 && !empty($userDiscounts[$user])) {
                $cartline->product->price_ex = (Configure::read('DiscountPrice'));
                $subtotal = $cartline->quantity * (Configure::read('DiscountPrice'));
            }
            
            if ($cartline->product->has_discount == 1 && empty($userDiscounts[$user])) {
                $subtotal = 1 * $cartline->product->price_ex;
                $subtotal += ($cartline->quantity-1) * (Configure::read('DiscountPrice'));
                $userDiscounts[$user] = true;
                $cartline->discount = ($cartline->quantity * $cartline->product->price_ex) - $subtotal;
            }
            
            //calc digital photos discount prijzen staffel
            if ($cartline->product->article === 'D1') {
                $userDigitalLines[$user] = isset($userDigitalLines[$user]) ? $userDigitalLines[$user]+1 : 1;
                $discount = $this->getDigitalDiscount($userDigitalLines[$user]);
                $subtotal = $cartline->product->price_ex - $discount;
                $cartline->discount = $discount;
            }
            $cartline->subtotal = $subtotal;
            $this->Cartlines->save($cartline);
        }
        
        $cart = $this->get($cart_id, [
        'contain' => [
        'Cartlines' => function ($q) {
            return $q
                ->order(['Cartlines.created'])
                ->contain([
                    'CartlineProductoptions.ProductoptionChoices.Productoptions'
                ]);
        },
         'Cartlines.Products',
         'Cartlines.Photos.Barcodes.Persons'
        ]
        ]);
         
        $users = Hash::extract($cart, 'cartlines.{n}.photo.barcode.person.user_id');
        $userDiscounts = array_map(function () {
        }, array_flip($users));
        if (!empty($cart->cartlines)) {
            foreach ($cart->cartlines as $cartline) {
                $cartline->discountPrice = Configure::read('DiscountPrice');
                if (!empty($userDiscounts[$user])
                        && $cartline->product->has_discount === 1) {
                    $cartline->product->price_ex = Configure::read('DiscountPrice');
                }
                 
                if ($cartline->product->has_discount === 1) {
                    $userDiscounts[$user] = true;
                }
            }
        }
        return $cart;
    }
    
    public function getCartTotals($cart_id)
    {
        $cart = $this->get($cart_id, [
            'contain' => [
                'Cartlines.Products'
            ]
        ]);
        
        $totals = [
            'products' => 0,
            'discount' => 0,
            'tax' => 0,
            'shippingcosts' => 8.95,
            'cartCount' => 0,
        ];
        
        $total_lines = 0;
        $high_shipping = false;
        foreach ($cart->cartlines as $line) {
            $total_lines+=$line->quantity;
            
            $totals['products'] += $line->subtotal;
//            $totals['discount'] += ($line->product->price_ex * $line->quantity) - $line->subtotal;
            $totals['discount'] += $line->discount;
            $totals['cartCount'] += $line->quantity;
            if(!empty($line->product->high_shipping)) {
                $high_shipping = true;
            }
        }
        
        if ($total_lines >= 4) {
            $totals['shippingcosts'] = 0;
        }
        if ($high_shipping) {
            $totals['shippingcosts'] = 12.50;
        }
        return $totals;
    }
    
    public function getDigitalDiscount($count)
    {
        if ($count <= 1) {
            return null;
        } elseif ($count === 2) {
            return 7.50;
        } elseif ($count === 3) {
            return 10;
        } elseif ($count >= 4) {
            return 12.50;
        }
    }
}
