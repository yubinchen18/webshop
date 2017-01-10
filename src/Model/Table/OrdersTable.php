<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Mailer\Email;
use Cake\Core\Configure;

// @codingStandardsIgnoreStart
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
 * @method \App\Model\Entity\Order patchEntity(\Cake\Datasource\EntityInterface $entity,
 *                                  array $data, array $options = [])
 * @method \App\Model\Entity\Order[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Order findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
// @codingStandardsIgnoreEnd
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
        $this->belongsTo('Carts', [
            'foreignKey' => 'order_id',
            'joinType' => 'LEFT'
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
        $this->hasMany('OrdersOrderstatuses', [
            'foreignKey' => 'order_id'
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
            ->allowEmpty('remarks');

        $validator
            ->allowEmpty('ideal_status');

        $validator
            ->allowEmpty('exportstatus');

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
        $rules->add($rules->existsIn(['deliveryaddress_id'], 'Deliveryaddresses'));
        $rules->add($rules->existsIn(['invoiceaddress_id'], 'Invoiceaddresses'));

        return $rules;
    }
    
    private function createIdent()
    {
        $ident = $this->find()->select(['ident'])->order(['created' => 'DESC'])->first();
        
        if (empty($ident)) {
            return 100000;
        }
        return (int)$ident->ident+1;
    }
    
    public function beforeSave($event, $entity, $options)
    {
        if ($entity->isNew() && empty($entity->ident)) {
            $entity->ident = $this->createIdent();
        }
        return $entity;
    }
    
    public function sendConfirmation($order, $payment_status = '')
    {
        $order = $this->get($order->id, ['contain' => ['Invoiceaddresses','Deliveryaddresses','Orderlines.Products']]);

        $cakeMail = new Email('default');
        $cakeMail->from([Configure::read('App.email') => Configure::read('App.title')]);
        $cakeMail
            ->to($order->invoiceaddress->email)
            ->subject(__('Bevestiging van uw bestelling'))
            ->domain('bestellen.hoogstratenfotografie.nl')
            ->template('order_confirmation')
            ->emailFormat('html')
            ->viewVars(compact('order','payment_status'))
            ->returnPath([Configure::read('App.email') => Configure::read('App.title')]);
        return $this->send($cakeMail);
    }
    
    public function send($cakeMail)
    {
        return $cakeMail->send();
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
    
    public function findOpenOrdersForPhotex()
    {
        $lastCreated = 'SELECT MAX(created) FROM orders_orderstatuses as OOST WHERE OOST.order_id = Orders.id';
        $orderstatusId = $this->OrdersOrderstatuses->Orderstatuses->find('byAlias', ['alias' => 'payment_received'])->first()->id;
        return $this->find()
            ->contain([
                'OrdersOrderstatuses' => function ($q) {
                    return $q
                        ->order(['OrdersOrderstatuses.created' => 'DESC'])
                        ->contain(['Orderstatuses']);
                },
            ])
            ->join([
                'table' => 'orders_orderstatuses',
                'alias' => 'OrdersOrderstatuses',
                'conditions' => [
                    'OrdersOrderstatuses.order_id = `Orders`.`id`',
                    'OrdersOrderstatuses.orderstatus_id' => $orderstatusId,
                    'Orders.exportstatus' => 'new',
                    'Orders.modified >' => date("Y-m-d", mktime(0, 0, 0, date("m") - 1, date("d"), date("Y"))),
                    sprintf('OrdersOrderstatuses.created = (%s)', $lastCreated)
                ],
                'type' => 'INNER'
            ])
            ->orderDesc('ident')
            ->all();
    }
    
    public function getLastOrderstatus($orderId)
    {
        $order = $this->get($orderId, [
            'contain' => [
                'OrdersOrderstatuses' => function ($q) {
                    return $q
                        ->order(['OrdersOrderstatuses.created' => 'DESC'])
                        ->contain(['Orderstatuses']);
                }
            ]
        ]);
        
        return $order->orders_orderstatuses[0]->orderstatus;
    }
    
    public function getOrderDataForPhotex($orderId, $notExportedOnly = true)
    {
        $orderlineConditions = [];
        if( $notExportedOnly == true ) {
            $orderlineConditions = ['exported' => 0];
        }
        return $this->get($orderId, [
            'contain' => [
                'Orderlines' => function ($q) use ($orderlineConditions) {
                    return $q
                        ->where($orderlineConditions)
                        ->contain([
                            'Photos', 
                            'Products',
                            'OrderlineProductoptions.ProductoptionChoices',
                        ]);
                },
                'Deliveryaddresses',
                'Invoiceaddresses',
            ]
        ]);
    }
    
    public function findSearchForPhotex(Query $query, array $options)
    {
        if (empty($options['searchTerm'])) {
            throw new \InvalidArgumentException('Missing search term');
        }
//        debug($options['searchTerm']);die();
        $lastCreated = 'SELECT MAX(created) FROM orders_orderstatuses as OOST WHERE OOST.order_id = Orders.id';
        $sentToPhotex = $this->OrdersOrderstatuses->Orderstatuses->find('byAlias', ['alias' => 'sent_to_photex'])->first()->id;
        $sentToCustomer = $this->OrdersOrderstatuses->Orderstatuses->find('byAlias', ['alias' => 'sent_to_customer'])->first()->id;
        $inTreatmentByPhotex = $this->OrdersOrderstatuses->Orderstatuses->find('byAlias', ['alias' => 'in_treatment_by_photex'])->first()->id;

        return $query
            ->contain([
                'OrdersOrderstatuses' => function ($q) {
                    return $q
                        ->order(['OrdersOrderstatuses.created' => 'DESC'])
                        ->contain(['Orderstatuses'])
                        ->limit(1);
                },
                'Orderlines.OrderlineProductoptions',
                'Users.Persons.Groups.Projects.Schools',
                'Deliveryaddresses',
                'Invoiceaddresses'
            ])
            ->join([
                'table' => 'orders_orderstatuses',
                'alias' => 'OrdersOrderstatuses',
                'conditions' => [
                    'OrdersOrderstatuses.order_id = `Orders`.`id`',
                    'OrdersOrderstatuses.orderstatus_id IN' => [$sentToPhotex, $inTreatmentByPhotex],
                    sprintf('OrdersOrderstatuses.created = (%s)', $lastCreated)
                ],
                'type' => 'INNER'
            ])
            ->where(['Orders.ident LIKE' => "%".$options['searchTerm']."%"])
            ->limit(6)
            ->order(['ident' => 'asc']);
    }
}
