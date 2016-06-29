<?php
namespace App\Controller\Api;

use App\Controller\AppController\Api;
use Cake\Utility\Security;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class QueuesController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Downloadqueues = TableRegistry::get('Downloadqueues');
    }

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


    private function checkGroups($object)
    {
        if (!empty($object['Groups']) && $object['Groups']['name'] == 'Onbekend') {
            $existingGroup = $this->Groups->find()
                    ->where([
                        'Groups.project_id' => $object['Groups']['project_id'],
                        'Groups.name' => 'Onbekend'])
                    ->first();

            if (!empty($existingGroup)) {
                $this->set('BarcodeId', $existingGroup->barcode_id);
                $this->set('ObjectId', $existingGroup->id);
                return false;
            }
        }
        return $object;
    }

    private function processUsers($object)
    {
        if (isset($object['Users'])) {
            unset($object['Users']['modified']);
            unset($object['Users']['created']);

            $userId = $object['Users']['online_id'];
            if ($object['Users']['online_id'] === 0) {
                unset($object['Users']['id']);
               
                $object['Users']['password'] = (new DefaultPasswordHasher)->hash($object['Users']['real_pass']);
                $object['Users']['genuine'] = $object['Users']['real_pass'];

                $entity = $this->Users->newEntity($object['Users']);
                $savedEntity = $this->Users->save($entity);
                $userId = $savedEntity->id;
            }

            $this->Downloadqueues->addDownloadQueueItem('Users', $userId, $this->getUser());
            unset($object['Users']);
            $this->userId = $userId;
            $this->result[] = $userId;
        }
        
        return $object;
    }

    private function processBarcodes($object)
    {
        if (!empty($object['Barcodes'])) {
            unset($object['Barcodes']['modified']);
            unset($object['Barcodes']['created']);

            $barcodeId = $object['Barcodes']['online_id'];
            if ($object['Barcodes']['online_id'] === 0) {
                unset($object['Barcodes']['id']);

                $entity = $this->Barcodes->newEntity($object['Barcodes']);
                $savedEntity = $this->Barcodes->save($entity);
                $barcodeId = $savedEntity->id;
            }
            
            $this->Downloadqueues->addDownloadQueueItem('Barcodes', $barcodeId, $this->getUser());
            unset($object['Barcodes']);
            $this->barcodeId = $barcodeId;
            $this->result[] = $barcodeId;
        }

        return $object;
    }

    private function setAddress($data)
    {
        return [
            'street' => $data['address'],
            'number' => 0,
            'extension' => null,
            'city' => $data['city'],
            'zipcode' => $data['zipcode'],
            'gender' => null,
            'firstname' => $data['firstname'],
            'prefix' => $data['prefix'],
            'lastname' => $data['lastname']
        ];
    }

    private function processPersons($model, $data)
    {
        $existingItem = $this->{$model}->find()
            ->where(['Persons.id' => $data['id']])
            ->first();

        if (!empty($existingItem)) {
            if ($existingItem->group_id != $data['group_id']) {
                $oldGroup = $this->Groups->find()
                    ->where(['id' => $existingItem->group_id])
                    ->first();

                $newGroup = $this->Groups->find()
                    ->where(['id' => $data['group_id']])
                    ->first();

                if (!empty($oldGroup) && !empty($newGroup)) {
                    $oldPath = APP . "userphotos" . DS . $this->Photos->getPath($data['barcode_id']);
                    $newPath = str_replace(
                        $oldGroup->id . '_' . $oldGroup->slug,
                        $newGroup->id . '_' . $newGroup->slug,
                        $oldPath
                    );

//                    if( !file_exists( $newPath ) ) {
//                        $this->chmodThroughFtp($oldPath);
//                        $this->chmodThroughFtp($newPath);
//
//                        mkdir(dirname($oldPath), 0777, true);
//                        mkdir(dirname($newPath), 0777, true);
//                    }
//
//                    $folder = new Folder();
//                    $folder->move(
//                        array(
//                                'to' => $newPath,
//                                'from' => $oldPath,
//                                'chmod' => 777
//                        )
//                    );
                }
            }
        }
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
                $data['address'] = $this->setAddress($data);
            }
           
            if ($data['online_id'] === 0) { //new
                unset($data['id']);
                $entity = $this->{$model}->newEntity($data);
            } else {
                $data['id'] = $data['online_id']; //existing

                if ($model == "Persons") {
                    $this->processPersons($model, $data);
                }
                $entity = $this->{$model}->get($data['id']);
                $entity = $this->{$model}->patchEntity($entity, $data);
            }

            $savedEntity = $this->{$model}->save($entity);
            
            $objectId = $savedEntity->id;
            $this->result[] = $objectId;
            if ($model != 'Photos') {
                $this->Downloadqueues->addDownloadQueueItem($model, $objectId, $this->getUser());
            }
        }
        return $object;
    }

    public function add()
    {
        $this->Groups = TableRegistry::get('Groups');
        $this->Photos = TableRegistry::get('Photos');
        $this->Users = TableRegistry::get('Users');
        $this->Barcodes = TableRegistry::get('Barcodes');
        
        $object = $this->Downloadqueues->formatInput($this->request->data());

        $this->result = [];
        $this->userId =0;
        $this->barcodeId =0;
        $this->objectId =0;

        if ($this->checkGroups($object)) {
            $object = $this->processUsers($object);
            $object = $this->processBarcodes($object);
            $object = $this->process($object);
            $this->set('result', $this->result);
        }
    }
}
