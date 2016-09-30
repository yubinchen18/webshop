<?php
namespace App\Model\Table;

use App\Model\Entity\Downloadqueue;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * Downloadqueues Model
 *
 */
class DownloadqueuesTable extends Table
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

        $this->table('downloadqueues');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Deletable');

        $this->belongsTo('Schools', [
            'foreignKey' => 'foreign_key',
            'joinType' => 'LEFT',
            'conditions' => ['model' => 'Schools']
        ]);

        $this->belongsTo('Barcodes', [
            'foreignKey' => 'foreign_key',
            'joinType' => 'LEFT',
            'conditions' => ['model' => 'Barcodes']
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'foreign_key',
            'joinType' => 'LEFT',
            'conditions' => ['model' => 'Users']
        ]);

        $this->belongsTo('Projects', [
            'foreignKey' => 'foreign_key',
            'joinType' => 'LEFT',
            'conditions' => ['model' => 'Projects']
        ]);
        $this->belongsTo('Groups', [
            'foreignKey' => 'foreign_key',
            'joinType' => 'LEFT',
            'conditions' => ['model' => 'Groups']
        ]);

        $this->belongsTo('Persons', [
            'foreignKey' => 'foreign_key',
            'joinType' => 'LEFT',
            'conditions' => ['model' => 'Persons']
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
            ->requirePresence('profile_name', 'create')
            ->notEmpty('profile_name');

        $validator
            ->requirePresence('model', 'create')
            ->notEmpty('model');

        $validator
            ->uuid('foreign_key')
            ->requirePresence('foreign_key', 'create')
            ->notEmpty('foreign_key');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }
    
    public function addDownloadQueueItem($model, $foreignKey, $username = '')
    {
        $this->Users =TableRegistry::get('Users');

        $conditions = [
            'Users.type' => 'photographer'
        ];
        
        if (!empty($username)) {
              $conditions['Users.username <>'] = $username;
        }
        
        $users = $this->Users->find('list', [
            'keyField' => 'id',
            'valueField' => 'username'
        ])
        ->where($conditions)->toArray();
        
        $result = true;
        foreach ($users as $id => $username) {
            $data = array(
                'profile_name' => $username,
                'model' => $model,
                'foreign_key' => $foreignKey
            );

            $existingItem = $this->find()
                    ->where($data)
                    ->first();
            
            if (empty($existingItem)) {
                $newDownloadQueue = $this->newEntity($data);
                $result = $this->save($newDownloadQueue);
            }
        }
        
        return $result;
    }

    public function formatInput($data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->formatInput($value);
                continue;
            }

            if (preg_match("|/Date\((.*?)\)/|si", $value, $matches)) {
                $microtime = (float)substr($matches[1], 0, -3) . ".00";
                $data[$key] = date("Y-m-d H:m:s", $microtime);
            }
        }

        return $data;
    }
}
