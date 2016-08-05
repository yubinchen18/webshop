<?php
namespace App\Model\Table;

use App\Model\Entity\School;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Hash;

/**
 * Schools Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Contacts
 * @property \Cake\ORM\Association\BelongsTo $Visitaddresses
 * @property \Cake\ORM\Association\BelongsTo $Mailaddresses
 * @property \Cake\ORM\Association\HasMany $Projects
 */
class SchoolsTable extends Table
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

        $this->table('schools');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Deletable');

        $this->belongsTo('Contacts', [
            'foreignKey' => 'contact_id',
            'joinType' => 'LEFT',
            'dependent' => true
        ]);
        $this->belongsTo('Visitaddresses', [
            'foreignKey' => 'visitaddress_id',
            'joinType' => 'LEFT',
            'className' => 'Addresses',
            'dependent' => true
        ]);
        $this->belongsTo('Mailaddresses', [
            'foreignKey' => 'mailaddress_id',
            'joinType' => 'LEFT',
            'className' => 'Addresses',
            'dependent' => true
        ]);
        $this->hasMany('Projects', [
            'foreignKey' => 'school_id'
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
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }
    
    public function findSearch(Query $query, array $options)
    {
        if (empty($options['searchTerm'])) {
            throw new \InvalidArgumentException('Missing search term');
        }
        return $query
                ->where(['name LIKE' => "%".$options['searchTerm']."%"])
                ->contain(['Contacts', 'Visitaddresses'])
                ->limit(6)
                ->order(['name' => 'asc']);
    }
    
    /**
     * Method finds all Projects, Classes and students for 
     * a school
     * 
     * @param Query $query
     * @param array $options
     */
    public function findTree(Query $query, array $options = []) {
        return $query
                ->contain(['Projects.Groups.Persons.Barcodes'])
                ->where([
                    'Schools.id' => $options['school_id'],
                  ]);
                
    }
}
