<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Orders Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Deliveryaddresses
 * @property \Cake\ORM\Association\BelongsTo $Invoiceaddresses
 * @property \Cake\ORM\Association\BelongsTo $Trxes
 * @property \Cake\ORM\Association\HasMany $Invoices
 * @property \Cake\ORM\Association\HasMany $Orderlines
 * @property \Cake\ORM\Association\HasMany $PhotexDownloads
 * @property \Cake\ORM\Association\BelongsToMany $Orderstatuses
 *
 * @method \App\Model\Entity\Order get($primaryKey, $options = [])
 * @method \App\Model\Entity\Order newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Order[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Order|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Order patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Order[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Order findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrdersTable extends Table
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

        $this->table('orders');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Deliveryaddresses', [
            'foreignKey' => 'deliveryaddress_id',
            'joinType' => 'INNER',
            'className' => 'Addresses'
        ]);
        $this->belongsTo('Invoiceaddresses', [
            'foreignKey' => 'invoiceaddress_id',
            'joinType' => 'INNER',
            'className' => 'Addresses'
        ]);
        $this->belongsTo('Trxes', [
            'foreignKey' => 'trx_id'
        ]);
        $this->hasMany('Invoices', [
            'foreignKey' => 'order_id'
        ]);
        $this->hasMany('Orderlines', [
            'foreignKey' => 'order_id'
        ]);
        $this->hasMany('PhotexDownloads', [
            'foreignKey' => 'order_id'
        ]);
        $this->belongsToMany('Orderstatuses', [
            'foreignKey' => 'order_id',
            'targetForeignKey' => 'orderstatus_id',
            'joinTable' => 'orders_orderstatuses'
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

        $validator
            ->requirePresence('ident', 'create')
            ->notEmpty('ident');

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

        return $rules;
    }
    
    /**
     * 
     * @param Query $query
     * @param array $options
     * @return type
     * @throws \InvalidArgumentException
     */
    public function findSearch(Query $query, array $options)
    {
        if (empty($options['searchTerm'])) {
            throw new \InvalidArgumentException('Missing search term');
        }
        return $query
                ->where(['ident LIKE' => "%".$options['searchTerm']."%"])
                ->contain(['Deliveryaddresses', 'Invoiceaddresses'])
                ->limit(6)
                ->order(['ident' => 'asc']);
    }
}
