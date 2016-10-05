<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

//@codingStandardsIgnoreStart
/**
 * Products Model
 *
 * @property \Cake\ORM\Association\HasMany $Orderlines
 * @property \Cake\ORM\Association\BelongsToMany $Productoptions
 *
 * @method \App\Model\Entity\Product get($primaryKey, $options = [])
 * @method \App\Model\Entity\Product newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Product[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Product|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Product patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Product[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Product findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
//@codingStandardsIgnoreEnd

class ProductsTable extends Table
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

        $this->table('products');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Orderlines', [
            'foreignKey' => 'product_id'
        ]);
        $this->hasMany('Cartlines', [
            'foreignKey' => 'product_id'
        ]);
        
        $this->belongsToMany('Productoptions', [
            'foreignKey' => 'product_id',
            'targetForeignKey' => 'productoption_id',
            'joinTable' => 'products_productoptions'
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
            ->requirePresence('article', 'create')
            ->notEmpty('article');

        $validator
            ->requirePresence('slug', 'create')
            ->notEmpty('slug');

        $validator
            ->allowEmpty('description');

        $validator
            ->numeric('price_ex')
            ->requirePresence('price_ex', 'create')
            ->notEmpty('price_ex');

        $validator
            ->numeric('vat')
            ->requirePresence('vat', 'create')
            ->notEmpty('vat');

        $validator
            ->boolean('high_shipping')
            ->allowEmpty('high_shipping');

        $validator
            ->boolean('active')
            ->allowEmpty('active');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        $validator
            ->requirePresence('layout', 'create')
            ->notEmpty('layout');

        return $validator;
    }
}
