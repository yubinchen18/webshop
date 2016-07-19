<?php
namespace App\Model\Table;

use App\Model\Entity\Barcode;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * Barcodes Model
 *
 * @property \Cake\ORM\Association\HasMany $Groups
 * @property \Cake\ORM\Association\HasMany $Persons
 * @property \Cake\ORM\Association\HasMany $Photos
 */
class BarcodesTable extends Table
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

        $this->table('barcodes');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasOne('Groups', [
            'foreignKey' => 'barcode_id'
        ]);
        $this->hasOne('Persons', [
            'foreignKey' => 'barcode_id'
        ]);
        $this->hasMany('Photos', [
            'foreignKey' => 'barcode_id'
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
            ->requirePresence('barcode', 'create')
            ->notEmpty('barcode');

        $validator
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }

    /**
     * Method to generate a custom unique barcode
     * Type standard is anonymous
     * @param type $type
     * @return type
     */
    public function generateBarcode($type = '*ano_')
    {
        $unique = base_convert(rand(0, 999999999999999), 10, 36);
        $barcode = $type . $unique;

        $barcodeExisting = $this->find()
            ->where(['barcode' => $barcode])
            ->first();

        if (!empty($barcodeExisting)) {
            $barcode = $this->generateBarcode($type);
        }

        return $barcode;
    }

    /**
     * Method to create a new barcode on the fly
     * @param type $prefix | Defines if a prefix is to be used
     *      Useful if an anonymous barcode must be created
     * @return Entity $barcode
     */
    public function createNewBarcode($prefix = '')
    {
        $barcode = $this->newEntity();
        $barcode->barcode = $this->generateBarcode($prefix);
        return $this->save($barcode);
        
    }
    
    public function processBarcodes($object, $user)
    {
        $barcodeId = null;
        $this->Downloadqueues = TableRegistry::get('Downloadqueues');
        unset($object['Barcodes']['modified']);
        unset($object['Barcodes']['created']);

        $barcodeId = $object['Barcodes']['online_id'];
        if ($object['Barcodes']['online_id'] === 0) {
            unset($object['Barcodes']['id']);

            $entity = $this->newEntity($object['Barcodes']);
            $savedEntity = $this->save($entity);
            $barcodeId = $savedEntity->id;
        }

        $this->Downloadqueues->addDownloadQueueItem('Barcodes', $barcodeId, $user);
        unset($object['Barcodes']);

        return [$object, $barcodeId];
    }
}
