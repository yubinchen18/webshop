<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductsProductoptions Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Productoptions
 * @property \Cake\ORM\Association\BelongsTo $Products
 *
 * @method \App\Model\Entity\ProductsProductoption get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProductsProductoption newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ProductsProductoption[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProductsProductoption|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProductsProductoption patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProductsProductoption[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProductsProductoption findOrCreate($search, callable $callback = null)
 */
class ProductsProductoptionsTable extends Table
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

        $this->table('products_productoptions');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Productoptions', [
            'foreignKey' => 'productoption_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
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
        $rules->add($rules->existsIn(['productoption_id'], 'Productoptions'));
        $rules->add($rules->existsIn(['product_id'], 'Products'));

        return $rules;
    }
}
