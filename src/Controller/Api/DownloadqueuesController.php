<?php
namespace App\Controller\Api;

use App\Controller\AppController\Api;
use Cake\Utility\Security;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;

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
    public function index()
    {
        $downloadqueueitems = $this->Downloadqueues->find()
                ->contain(['Schools', 'Barcodes', 'Users', 'Projects', 'Groups', 'Persons'])
                ->where(['profile_name' => $this->getUser()])
                ->ToArray();

        $this->set(compact('downloadqueueitems'));
    }

    public function remove()
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

    public function add()
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

        if(isset($object['Groups']['name']) && $object['Groups']['name'] == 'Onbekend') {
            $object = $this->Downloadqueues->formatInput($this->request->data());
            $groupCheck = $this->Groups->checkGroups($object);
            if($groupCheck !== false) {
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
            if(isset($barcodeId)) {
                $this->result[] = $barcodeId;
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

            if ($this->barcodeId != 0) {
                $data['barcode_id'] = $this->barcodeId;
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

            $savedEntity = $this->{$model}->save($entity);
            
            if($savedEntity === false) {
                pr($entity->errors);
            }
            $objectId = $savedEntity->id;
            $this->result[] = $objectId;
            if ($model != 'Photos') {
                $this->Downloadqueues->addDownloadQueueItem($model, $objectId, $this->getUser());
            }
        }
        return $object;
    }
}
