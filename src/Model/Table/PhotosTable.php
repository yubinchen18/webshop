<?php
namespace App\Model\Table;

use App\Model\Entity\Photo;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;

/**
 * Photos Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Barcodes
 * @property \Cake\ORM\Association\HasMany $Orderlines
 */
class PhotosTable extends Table
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

        $this->table('photos');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Deletable');
        
        $this->belongsTo('Barcodes', [
            'foreignKey' => 'barcode_id',
            'joinType' => 'INNER'
        ]);
//        $this->hasMany('Orderlines', [
//            'foreignKey' => 'photo_id'
//        ]);
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
            ->requirePresence('path', 'create')
            ->notEmpty('path');

        $validator
            ->requirePresence('type', 'create')
            ->notEmpty('type');

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
        $rules->add($rules->existsIn(['barcode_id'], 'Barcodes'));
        return $rules;
    }

    public function getPath($barcode_id)
    {

        $aBarcode = $this->Barcodes->find()
                ->where(["Barcodes.id" => $barcode_id])
                ->contain(['Groups.Projects.Schools', 'Persons.Groups.Projects.Schools'])
                ->first();
        
        if ($aBarcode->type == "group") {
            $path = $aBarcode->group->project->school->id .
            "_" .
            $aBarcode->group->project->school->slug .
            "/" .
            $aBarcode->group->project->id .
            "_" .
            $aBarcode->group->project->slug .
            "/" .
            $aBarcode->group->id .
            "_" .
            $aBarcode->group->slug;
            return $path;
        }
            
            $sModel = $aBarcode->type;
            $path = $aBarcode->{$sModel}->group->project->school->id .
            "_" .
            $aBarcode->{$sModel}->group->project->school->slug .
            "/" .
            $aBarcode->{$sModel}->group->project->id .
            "_" .
            $aBarcode->{$sModel}->group->project->url .
            "/" .
            $aBarcode->{$sModel}->group->id .
            "_" .
            $aBarcode->{$sModel}->group->url .
            "/" .
            $aBarcode->{$sModel}->id .
            "_" .
            $aBarcode->{$sModel}->url;

            return $path;
    }
}
