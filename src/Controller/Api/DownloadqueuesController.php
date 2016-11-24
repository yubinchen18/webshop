<?php
namespace App\Controller\Api;

use App\Controller\AppController\Api;
use Cake\Utility\Security;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Routing\RouteBuilder;
use Cake\Utility\Inflector;
use App\Lib\ApiMapper;

/**
 * Downloadqueues Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class DownloadqueuesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function listQueue()
    {
        $downloadqueueitems = $this->Downloadqueues->find()
                ->contain([ 'Schools', 'Barcodes', 'Users', 'Projects', 'Groups', 'Persons.Addresses'])
                ->where(['Downloadqueues.profile_name' => $this->getUser()]);
        $DownloadQueueItems = [];
        foreach ($downloadqueueitems as $queueitem) {
            $model = Inflector::singularize($queueitem->model);
            if (!isset($queueitem->{strtolower($model)})) {
                continue;
            }
            $item = [
                'Id' => $queueitem->id,
                'Model' => $model,
                'ForeignKey' => $queueitem->foreign_key,
                'Modified' => $queueitem->modified->format('Y-m-d'),
                'Created' => $queueitem->created->format('Y-m-d')
            ];
            $data = ApiMapper::map($model, $queueitem);
            $DownloadQueueItems[] = array_merge($item, $data);//$item+$data;
        }
        $this->set(compact('DownloadQueueItems'));
    }

    public function removeFromQueue()
    {
        $queueItemIds = $this->request->data();

        $removingItems = $this->Downloadqueues->find()
            ->where([
                'id IN' => $queueItemIds,
                'profile_name' => $this->getUser()
            ])
            ->toArray();

        foreach ($removingItems as $deleteItem) {
            $this->Downloadqueues->delete($deleteItem);
        }
        
        $this->set(compact('removingItems'));
    }

    public function uploadItem()
    {
        $this->Groups = TableRegistry::get('Groups');
        $this->Photos = TableRegistry::get('Photos');
        $this->Users = TableRegistry::get('Users');
        $this->Barcodes = TableRegistry::get('Barcodes');
        $this->Addresses = TableRegistry::get('Addresses');

        $object = $this->Downloadqueues->formatInput($this->request->data());

        $this->result = [];
        $this->userId =0;
        $this->barcodeId =0;
        $this->objectId =0;

        if (isset($object['Groups']['name']) && $object['Groups']['name'] == 'Onbekend') {
            $groupCheck = $this->Groups->checkGroups($object);
            if ($groupCheck !== false) {
                $this->set('BarcodeId', $groupCheck['BarcodeId']);
                $this->set('GroupId', $groupCheck['GroupId']);
                return;
            }
        }

        if (!empty($object['Users'])) {
            list($object, $userId) = $this->Users->processUsers($object, $this->getUser());
            $this->userId = $userId;
            $this->result['id'] = $userId;
        }

        if (!empty($object['Barcodes'])) {
            list($object, $barcodeId) = $this->Barcodes->processBarcodes($object, $this->getUser());
            if (isset($barcodeId)) {
                $this->result['id'] = $barcodeId;
                $this->barcodeId = $barcodeId;
            }
        }
        $object = $this->process($object);
        $this->set('result', $this->result);
    }
    
    private function process($object)
    {
        foreach ($object as $model => $data) {
            $this->{$model} = TableRegistry::get($model);
            unset($data['modified']);
            unset($data['deleted']);
            unset($data['created']);

            if ($this->barcodeId != RouteBuilder::UUID) {
                $data['barcode_id'] = $this->barcodeId;
            }

            if ($model == "Photos") {
                $path = $this->Photos->getPath($data['barcode_id']);
                $photoFile = base64_decode($data['data']);
                
                $photoPath = $path . DS . basename($data['path']);
                file_put_contents($photoPath, $photoFile);
                
                if(!strstr($this->Photos->baseDir, 'vfs')){
                    $pic = new \Imagick($photoPath);
                    $this->Photos->autoRotateImage($pic);
                }
                
            }
            
            if ($model == "Persons") {
                $data['address'] = $this->Addresses->setEntityData($data);
            }
           
            if (empty($data['online_id'])) { //new
                unset($data['id']);
                if ($model == "Persons") {
                    $data['user_id'] = $this->Users->newUser($data);
                    $this->result['user_id'] = $data['user_id'];
                }
                
                $entity = $this->{$model}->newEntity($data);
            } else {
                $data['id'] = $data['online_id']; //existing
                if ($model == "Persons") {
                    $this->Persons->processPersons($data);
                }
                $entity = $this->{$model}->get($data['id']);
                unset($data['id']);
                $entity = $this->{$model}->patchEntity($entity, $data);
            }
            
            $savedEntity = $this->{$model}->save($entity, ['api_user' => $this->getUser()]);
            if (!$savedEntity) {
                var_dump($entity->errors());
                die();
            }
            $objectId = $savedEntity->id;
            $this->result['id'] = $objectId;
        }
        return $object;
    }
}
