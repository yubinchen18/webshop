<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrderlineProductoptions Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Orderlines
 * @property \Cake\ORM\Association\BelongsTo $ProductoptionChoices
 *
 * @method \App\Model\Entity\OrderlineProductoption get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrderlineProductoption newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OrderlineProductoption[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrderlineProductoption|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrderlineProductoption patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrderlineProductoption[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrderlineProductoption findOrCreate($search, callable $callback = null)
 */
class OrderlineProductoptionsTable extends Table
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

        $this->table('orderline_productoptions');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Orderlines', [
            'foreignKey' => 'orderline_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ProductoptionChoices', [
            'foreignKey' => 'productoption_choice_id',
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
        $rules->add($rules->existsIn(['orderline_id'], 'Orderlines'));
        $rules->add($rules->existsIn(['productoption_choice_id'], 'ProductoptionChoices'));

        return $rules;
    }
}
