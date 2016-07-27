<?php
namespace App\Model\Table;

use App\Model\Entity\Address;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Addresses Model
 *
 * @property \Cake\ORM\Association\HasMany $Invoices
 * @property \Cake\ORM\Association\HasMany $Persons
 * @property \Cake\ORM\Association\HasMany $Users
 */
class AddressesTable extends Table
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

        $this->table('addresses');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Deletable');

        $this->hasMany('Invoices', [
            'foreignKey' => 'address_id'
        ]);
        $this->hasMany('Persons', [
            'foreignKey' => 'address_id'
        ]);
        $this->hasMany('Users', [
            'foreignKey' => 'address_id'
        ]);
        $this->hasMany('Deliveryorders', [
            'foreignKey' => 'deliveryaddress_id',
            'className' => 'Orders'
        ]);
        $this->hasMany('Invoiceorders', [
            'foreignKey' => 'invoiceaddress_id',
            'className' => 'Orders'
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
            ->requirePresence('street', 'create')
            ->notEmpty('street');

        $validator
            ->allowEmpty('number');

        $validator
            ->allowEmpty('extension');

        $validator
            ->requirePresence('zipcode', 'create')
            ->notEmpty('zipcode');

        $validator
            ->requirePresence('city', 'create')
            ->notEmpty('city');

        $validator
            ->allowEmpty('gender');

        $validator
            ->allowEmpty('firstname');

        $validator
            ->allowEmpty('prefix');

        $validator
            ->allowEmpty('lastname');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }

    public function setEntityData($data) //setAddress
    {
        return [
            'street' => $data['address'],
            'number' => 0,
            'extension' => null,
            'city' => $data['city'],
            'zipcode' => $data['zipcode'],
            'gender' => null,
            'firstname' => $data['firstname'],
            'prefix' => $data['prefix'],
            'lastname' => $data['lastname']
        ];
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
                /*->join([
                        'Deliveryorders' => [
                            'table' => 'orders',
                            'type' => 'LEFT',
                            'conditions' => 'Deliveryorders.deliveryaddress_id = Addresses.id'
                        ],
                        'Invoiceorders' => [
                            'table' => 'orders',
                            'type' => 'LEFT',
                            'conditions' => 'Invoiceorders.invoiceaddress_id = Addresses.id'
                        ]                    
                ])*/
                //->where(['Deliveryorders.ident LIKE' => "%$searchTerm%"])
                //->orWhere(['Invoiceorders.ident LIKE' => "%$searchTerm%"])
                ->where(['Addresses.lastname LIKE' => "%".$options['searchTerm']."%"])
                ->orWhere(['Addresses.zipcode LIKE' => "%".$options['searchTerm']."%"])
                //->contain(['Deliveryorders', 'Invoiceorders'])
                ->limit(6)
                ->order(['Addresses.lastname' => 'asc']);
    }
}
