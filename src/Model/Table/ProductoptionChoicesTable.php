<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductoptionChoices Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Productoptions
 * @property \Cake\ORM\Association\HasMany $CartlineProductoptions
 * @property \Cake\ORM\Association\HasMany $OrderlineProductoptions
 *
 * @method \App\Model\Entity\ProductoptionChoice get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProductoptionChoice newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ProductoptionChoice[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProductoptionChoice|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProductoptionChoice patchEntity(\Cake\Datasource\
 *          EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProductoptionChoice[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProductoptionChoice findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductoptionChoicesTable extends Table
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

        $this->table('productoption_choices');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Productoptions', [
            'foreignKey' => 'productoption_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('CartlineProductoptions', [
            'foreignKey' => 'productoption_choice_id'
        ]);
        $this->hasMany('OrderlineProductoptions', [
            'foreignKey' => 'productoption_choice_id'
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
            ->requirePresence('value', 'create')
            ->notEmpty('value');

        $validator
            ->allowEmpty('description');

        $validator
            ->boolean('default')
            ->allowEmpty('default');

        $validator
            ->numeric('price_ex')
            ->allowEmpty('price_ex');

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
        $rules->add($rules->existsIn(['productoption_id'], 'Productoptions'));

        return $rules;
    }
    
    public function checkIdByName($optionName, $optionValue)
    {
        $choice = $this->find()
            ->select('id')
            ->where([
                'productoption_id' => $this->Productoptions->find()
                    ->select('id')
                    ->where(['name' => $optionName])
                    ->first()
                    ->id,
                'value' => $optionValue
            ])
            ->first();
        if (!empty($choice)) {
            return $choice->id;
        }
        return false;
    }
}
