<?php
namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Addresses
 * @property \Cake\ORM\Association\HasMany $Orders
 * @property \Cake\ORM\Association\HasMany $OrdersOrderstatuses
 * @property \Cake\ORM\Association\HasMany $Persons
 */
class UsersTable extends Table
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

        $this->table('users');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Deletable');
        
        $this->belongsTo('Addresses', [
            'foreignKey' => 'address_id'
        ]);
        $this->hasMany('Orders', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('OrdersOrderstatuses', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Persons', [
            'foreignKey' => 'user_id'
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
            ->requirePresence('username', 'create')
            ->notEmpty('username');

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password');

        $validator
            ->requirePresence('genuine', 'create')
            ->notEmpty('genuine');

        $validator
            ->email('email')
            ->allowEmpty('email');

        $validator
            ->allowEmpty('type');

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
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->isUnique(['email']));
        return $rules;
    }

    /**
     *
     * @param Query $query
     * @param array $options
     * @return Query
     */
    public function findBasicAuthUsers(Query $query, array $options)
    {
        $query->where(['type' => 'photographer'])
        ->orWhere([
            'username' => $options['username'],
            'type' => 'admin']);
        return $query;
    }
    
    public function processUsers($object, $username)
    {
        $this->Downloadqueues = TableRegistry::get('Downloadqueues');

        unset($object['Users']['modified']);
        unset($object['Users']['created']);

        $userId = $object['Users']['online_id'];
        if ($object['Users']['online_id'] === 0) {
            unset($object['Users']['id']);

            $object['Users']['password'] = (new DefaultPasswordHasher)->hash($object['Users']['real_pass']);
            $object['Users']['genuine'] = $object['Users']['real_pass'];

            $entity = $this->newEntity($object['Users']);
            $savedEntity = $this->save($entity);
            $userId = $savedEntity->id;
        }

        $this->Downloadqueues->addDownloadQueueItem('Users', $userId, $username);

        unset($object['Users']);

        return [$object, $userId,];
    }

    public function checkUsername($username)
    {
        $users = $this->find('list', [
                'keyField' => 'username',
                'valueField' => 'id'
            ])
            ->where(['username LIKE' => $username.'%'])
            ->toArray();

        if (empty($users)) {
            return $username;
        }

        $found = false;
        while ($found == false) {
            $newUsername = $username . $this->generateRandom(3);
            if (!isset($users[$newUsername])) {
                $found = true;
                $username = $newUsername;
            }
        }

        return $username;
    }

    public function generateRandom($length = 8)
    {
        $password = "";
        $chars = "ABCDEFGHJKLMNPQRSTUVWXYZ123456789";
        $charlength = strlen($chars) - 1;
        for ($i = 0; $i < $length; $i++) {
            $password .= substr($chars, mt_rand(0, $charlength), 1);
        }

        return $password;
    }
}
