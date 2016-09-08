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
                ->contain([ 'Schools', 'Barcodes', 'Users', 'Projects', 'Groups', 'Persons'])
                ->where(['Downloadqueues.profile_name' => $this->getUser()]);
        
        $DownloadQueueItems = [];
        foreach($downloadqueueitems as $queueitem) {
            $model = Inflector::singularize($queueitem->model);
            $item = [
                'Id' => $queueitem->id,
                'Model' => $model,
                'ForeignKey' => $queueitem->foreign_key,
                'Modified' => $queueitem->modified->format('Y-m-d'),
                'Created' => $queueitem->created->format('Y-m-d')
            ];
            $data = ApiMapper::map($model, $queueitem);
            $DownloadQueueItems[] = $item+$data;
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
            $this->result[] = $userId;
        }

        if (!empty($object['Barcodes'])) {
            list($object, $barcodeId) = $this->Barcodes->processBarcodes($object, $this->getUser());
            if (isset($barcodeId)) {
                $this->result[] = $barcodeId;
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
                foreach ($data['data'] as $key => $imagedata) {
                    $filename = basename($data['path']);

                    if ($key != 'original') {
                        $filename .= '_' . $key;
                    }

                    $decoded = base64_decode($imagedata);
                    file_put_contents($path . DS . $filename, $decoded);
                }
            }
            
            if ($model == "Persons") {
                $data['user_id'] = $this->userId;
                $data['address'] = $this->Addresses->setEntityData($data);
            }
           
            if ($data['online_id'] === 0) { //new
                unset($data['id']);
                $entity = $this->{$model}->newEntity($data);
            } else {
                $data['id'] = $data['online_id']; //existing
                
                if ($model == "Persons") {
                    $this->Persons->processPersons($data);
                }
                $entity = $this->{$model}->get($data['id']);
                $entity = $this->{$model}->patchEntity($entity, $data);
            }
            
            $savedEntity = $this->{$model}->save($entity,['api_user' => $this->getUser()]);
            
            if ($savedEntity === false) {
                pr($entity->errors);
            }
            $objectId = $savedEntity->id;
            $this->result[] = $objectId;
            
        }
        return $object;
    }
}
