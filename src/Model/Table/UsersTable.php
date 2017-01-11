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
        $this->hasOne('Carts', [
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
            ->notEmpty('profile_photo_filename');

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

        $userId = !empty($object['Users']['online_id'])?$object['Users']['online_id']:null;
        if (empty($userId)) {
            unset($object['Users']['id']);

            $object['Users']['password'] = (new DefaultPasswordHasher)->hash($object['Users']['real_pass']);
            $object['Users']['genuine'] = $object['Users']['real_pass'];

            $entity = $this->newEntity($object['Users']);
            $savedEntity = $this->save($entity);
            $userId = $savedEntity->id;
        }

        unset($object['Users']);

        return [$object, $userId];
    }

    public function newUser($data)
    {
        $user = $this->newEntity();
        if(empty($data['username'])) {
            $data['username'] = substr($data['firstname'], 0, 4) . substr($data['zipcode'], 0, 2). substr($data['type'], 1, 3);
        }
        if(empty($data['password'])) {
            $data['password'] = $this->generateRandom();
        }
        $data = [
            'username' => $this->checkUsername($data['username']),
            'password' => $data['password'],
            'genuine' => $data['password'],
            'type' => 'person'
        ];
        
        $user = $this->patchEntity($user, $data);
        $user = $this->save($user);
        
        return $user->id;
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
    
    public function getUserPortrait($userId)
    {
        $photo = null;
        $person = $this->Persons->find()
            ->where(['user_id' => $userId])
            ->contain(['Barcodes.Photos'])
            ->first();
        if ($person) {
            $dbPhotos = $person->barcode->photos;
            if (!empty($dbPhotos)) {
                $photo = $dbPhotos[0];
                // add orientation data to photo object
                $filePath = $this->Persons->Barcodes->Photos->getPath($person->barcode_id) . DS . $photo->path;
                $dimensions = getimagesize($filePath);
                if ($dimensions[0] > $dimensions[1]) {
                    $orientationClass = 'photos-horizontal';
                } else {
                    $orientationClass = 'photos-vertical';
                }
                $photo->orientationClass = $orientationClass;
            }
        }
        return $photo;
    }
    
    public function getSystemUser()
    {
        $systemUser = $this->findByTypeAndEmail('admin', 'support@xseeding.nl')->first();
        if (empty($systemUser)) {
            $user = $this->newEntity();
            $password = 'xseeding';
            $data = [
                'username' => 'xseeding',
                'email' => 'support@xseeding.nl',
                'password' => $password,
                'genuine' => $password,
                'type' => 'admin',
                'active' => '1'
            ];
            $user = $this->patchEntity($user, $data);
            $user = $this->save($user);
            return $user;
        }
        return $systemUser;
    }
}
