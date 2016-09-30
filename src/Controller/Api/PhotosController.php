<?php
namespace App\Controller\Api;

use App\Controller\AppController\Api;
use Cake\Utility\Security;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Auth\BasicAuthenticate;
use Cake\ORM\TableRegistry;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class PhotosController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function getPhotos($modelName, $id)
    {
        $this->Model = TableRegistry::get($modelName);
        $this->Photos = TableRegistry::get('Photos');
        $modelData = $this->Model->get($id);
        $barcodeIds = [];

        if ($modelName == 'projects') {
            $groupBarcodeIds = $this->Model->Groups->find('list', [
                'keyField' => 'id',
                'valueField' => 'barcode_id'
            ])
            ->where(['Groups.project_id' => $id])
            ->toArray();

            $studentBarcodeIds = $this->Model->Groups->Persons->find('list', [
                'keyField' => 'id',
                'valueField' => 'barcode_id'
            ])
            ->where(['Persons.group_id IN' => array_keys($groupBarcodeIds)])
            ->toArray();

            $barcodeIds = array_merge(array_values($groupBarcodeIds), array_values($studentBarcodeIds));
        } elseif ($modelName == 'groups') {
            $barcodeIds = $this->Model->Persons->find('list', [
                'keyField' => 'id',
                'valueField' => 'barcode_id'
            ])
            ->where(['Persons.group_id' => $id])
            ->toArray();
        }

        if (!empty($modelData->barcode_id)) {
            $barcodeIds[] = $modelData->barcode_id;
        }

        $photos = $this->Photos->find()
                ->where(['Barcode_id IN' => $barcodeIds])
                ->contain(['Barcodes'])
                ->toArray();

        $this->set('Photos', $photos);
    }

    public function getPhoto($id)
    {
        $photo = $this->Photos->get($id);
        $file = ROOT . DS . $photo->path;
        $mimetype = mime_content_type($file);
        $size   = filesize($file);

        header('Content-Type: ' . $mimetype);
        header('Content-Description: File Transfer');
        header('Content-Type: ' . $mimetype);
        header('Content-Disposition: attachment; filename= ' . basename($photo->path));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: public');
        header('Pragma: public');
        header('Content-Length: ' . $size);
        readfile($file);
    }
}
