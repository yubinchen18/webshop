<?php
namespace App\Model\Table;

use App\Model\Entity\Photo;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

/**
 * Photos Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Barcodes
 * @property \Cake\ORM\Association\HasMany $Orderlines
 */
class PhotosTable extends BaseTable
{
    public $baseDir = APP . 'userphotos';
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
        $barcode = $this->Barcodes->find()
                ->where(["Barcodes.id" => $barcode_id])
                ->contain(['Groups.Projects.Schools', 'Persons.Groups.Projects.Schools'])
                ->first();


        $path = $this->getPathObject();
        
        if (empty($barcode->person->group->project->school->slug)) {
            $path->create('unknown');
            $path->cd('unknown');

            return $path->path;
        }
        if ($barcode->type == "group") {
            $pathToCreate = $barcode->person->group->project->school->slug . DS .
                $barcode->person->group->project->slug . DS .
                $barcode->person->group->slug;
                $path->create($pathToCreate);
                $path->cd($pathToCreate);

            return $path->path;
        }
        
        $pathToCreate = $barcode->person->group->project->school->slug . DS .
                $barcode->person->group->project->slug . DS .
                $barcode->person->group->slug . DS . $barcode->person->slug;
        $path->create($pathToCreate);
        $path->cd($pathToCreate);
        $path->create('thumbs');
        $path->create('med');
        
        return $path->path;
    }

    private function getPathObject()
    {
        return new Folder($this->baseDir);
    }
    
    public function move($oldPath, $photo)
    {
        $newPath = $this->getPath($photo->barcode_id);
                      
        if (is_file($oldPath . DS . 'thumbs' . DS . $photo->path)) {
            $file = new File($oldPath . DS . 'thumbs' . DS . $photo->path);
            $file->copy($newPath . DS . 'thumbs' . DS . $photo->path);
            $file->delete($oldPath . DS . 'thumbs' . DS . $photo->path);
        }
        
        if (is_file($oldPath . DS . 'med' . DS . $photo->path)) {
            $file = new File($oldPath . DS . 'med' . DS . $photo->path);
            $file->copy($newPath . DS . 'med' . DS . $photo->path);
            $file->delete($oldPath . DS . 'med' . DS . $photo->path);
        }
        
        if (is_file($oldPath . DS . $photo->path)) {
            $file = new File($oldPath . DS . $photo->path);
            $file->copy($newPath . DS . $photo->path);
            $file->delete($oldPath . DS . $photo->path);
        }
        return true;
    }
    
    /**
     * Method to rotate the image automatically
     * Also resizes the image to thumb and medium format
     *
     * @param Imagick Object $image
     * @param string $return
     * @return string image path
     */
    public function autoRotateImage($image, $return = 'original')
    {
        $orientation = $image->getImageOrientation();
        
        switch ($orientation) {
            case 3:
                $image->rotateimage("#000", 180);
                break;

            case 6:
                $image->rotateimage("#000", 90);
                break;

            case 8:
                $image->rotateimage("#000", -90);
                break;
        }

        // Now that it's auto-rotated, make sure
        // the EXIF data is correct in case the EXIF gets saved with the image
        $image->setImageOrientation(1);
        $imgPath = $image->getImageFilename();
        $path = substr(strrchr($imgPath, DS), 1);
        $rawPath = str_replace($path, "", $imgPath);
        
        $thumbPath = $rawPath.DS."thumbs".DS.$path;
        $medPath = $rawPath.DS."med".DS.$path;
        
        $image->writeImage($imgPath);
        
        $image->scaleImage(0, 400);
        $image->writeImage($medPath);
        
        $image->scaleImage(0, 100);
        $image->writeImage($thumbPath);
        
        switch ($return) {
            case "med":
                return $medPath;
                break;
            
            case "thumbs":
                return $thumbPath;
                break;
            
            default:
                return $imgPath;
                break;
        }
    }
}
