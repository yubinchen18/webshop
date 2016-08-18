<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Filesystem\Folder;
use Cake\Network\Exception\NotFoundException;
use App\Lib\ImageHandler;

/**
 * Photos Controller
 *
 * @property \App\Model\Table\PhotosTable $Photos
 */
class PhotosController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $personId = $this->request->session()->read('Auth.User.id');
        //temporary fix for test, should be $personId = $this->Auth->user('id')
        if (!$personId) {
            $personId = '8273af3e-1fc8-44e6-ae0e-021a4a955965';
        }
        $personsTable = TableRegistry::get('Persons');
        $person = $personsTable->find()
                ->where(['Persons.id' => $personId])
                ->contain(['Barcodes.Photos'])
                ->first();
        //add the orientation data to the photos array
        if (isset($person)) {
            foreach ($person->barcode->photos as $key => $photo) {
                $filePath = $this->Photos->getPath($person->barcode_id) . DS . $photo->path;
                $dimensions = getimagesize($filePath);
                if ($dimensions[0] > $dimensions[1]) {
                    $orientationClass = 'photos-horizontal';
                } else {
                    $orientationClass = 'photos-vertical';
                }
                $photo->orientationClass = $orientationClass;
            }
        } else {
            $this->Flash->error(__('This person is not found or doesn\'t have any photos.'));
        }
        
        $this->set(compact('person'));
        $this->set('_serialize', ['photos']);
    }
    
    /**
     * View method
     *
     * @param string|null $id Photo id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        //check if user is auth to view this photo id
        $personId = $this->request->session()->read('Auth.User.id');
        //temporary fix for test, should be $personId = $this->Auth->user('id')
        if (!$personId) {
            $personId = '8273af3e-1fc8-44e6-ae0e-021a4a955965';
        }
        
        //load the person and photo
        $personsTable = TableRegistry::get('Persons');
        $person = $personsTable->find()
                ->where(['Persons.id' => $personId])
                ->contain(['Barcodes'])
                ->first();
        
        if (!empty($person)) {
            $photo = $this->Photos->find()
                ->where(['Photos.id' => $id, 'Photos.barcode_id' => $person->barcode->id])
                ->contain(['Barcodes'])
                ->first();

            if (!empty($photo)) {
                //add the orientation data to the photos array
                $filePath = $this->Photos->getPath($photo->barcode_id) . DS . $photo->path;
                $dimensions = getimagesize($filePath);
                if ($dimensions[0] > $dimensions[1]) {
                    $orientationClass = 'photos-horizontal';
                } else {
                    $orientationClass = 'photos-vertical';
                }
                $photo->orientationClass = $orientationClass;

                $this->set(compact('person', 'photo'));
                $this->set('_serialize', ['photo']);
            } else {
                throw new NotFoundException('Photo not found');
            }
        } else {
            throw new NotFoundException('Person not found');
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $photo = $this->Photos->newEntity();
        if ($this->request->is('post')) {
            $photo = $this->Photos->patchEntity($photo, $this->request->data);
            if ($this->Photos->save($photo)) {
                $this->Flash->success(__('The photo has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The photo could not be saved. Please, try again.'));
            }
        }
        $barcodes = $this->Photos->Barcodes->find('list', ['limit' => 200]);
        $this->set(compact('photo', 'barcodes'));
        $this->set('_serialize', ['photo']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Photo id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $photo = $this->Photos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $photo = $this->Photos->patchEntity($photo, $this->request->data);
            if ($this->Photos->save($photo)) {
                $this->Flash->success(__('The photo has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The photo could not be saved. Please, try again.'));
            }
        }
        $barcodes = $this->Photos->Barcodes->find('list', ['limit' => 200]);
        $this->set(compact('photo', 'barcodes'));
        $this->set('_serialize', ['photo']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Photo id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $photo = $this->Photos->get($id);
        if ($this->Photos->delete($photo)) {
            $this->Flash->success(__('The photo has been deleted.'));
        } else {
            $this->Flash->error(__('The photo could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    /**
     *
     * @param type $size
     * @param type $id
     * @return type
     */
    public function display($size, $id)
    {
        $photo = $this->Photos->find()
              ->where(['id' => $id])
              ->first();
        
        if (!empty($photo)) {
            $rawPath = $this->Photos->getPath($photo->barcode_id);
            if (in_array($size, ['thumbs','med'])) {
                $rawPath = $this->Photos->getPath($photo->barcode_id) . DS . $size;
            }
            
            $file = $rawPath . DS . $photo->path;
            $this->response->type(['jpg' => 'image/jpeg']);
            $this->response->file($file, ['name' => $photo->path]);
            return $this->response;
        } else {
            throw new NotFoundException('Photo Id: '.$id. ' was not found.');
        }
    }
    
    public function combine($id = null)
    {
        $this->autoRender = false;
        
        //check if user is auth to view this photo id
        $personId = $this->request->session()->read('Auth.User.id');
        //temporary fix for test, should be $personId = $this->Auth->user('id')
        if (!$personId) {
            $personId = '8273af3e-1fc8-44e6-ae0e-021a4a955965';
        }
        
        //load the person and photo
        $personsTable = TableRegistry::get('Persons');
        $person = $personsTable->find()
                ->where(['Persons.id' => $personId])
                ->contain(['Barcodes'])
                ->first();
        
        if (!empty($person)) {
            $photo = $this->Photos->find()
                ->where(['Photos.id' => $id, 'Photos.barcode_id' => $person->barcode->id])
                ->contain(['Barcodes'])
                ->first();

            if (!empty($photo)) {
                //show combine photos
                $sourcePath = $this->Photos->getPath($photo->barcode_id) . DS . $photo->path;
                $imageHandler = new ImageHandler();
                $images = $imageHandler->createProductPreview($id, 'CombinationSheet');pr($images);die();
                $combinationSheet = new CombinationSheet();
//                $imageHandler->createProduct($sourcePath, 'combination', 'CombinationLayout5');
//                pr($photos = $imageHandler->createProduct('combination', 'CombinationLayout5'));

                $this->set(compact('person', 'images'));
                $this->set('_serialize', ['images']);
            } else {
                throw new NotFoundException('Photo not found');
            }
        } else {
            throw new NotFoundException('Person not found');
        }
        
//        $path = APP . 'userphotos'.DS.'FPDF-School'.DS.'leeg-project'.DS.'photo-klas'.DS.'gebruikeruser-gebruikeruser'.DS.'med'.DS.'Etui.jpg';
//        
//        $layout1 = [
//        [
//            'start_x_cm'    => 0.00,
//            'start_y_cm'    => 9.50,
//            'width_cm'      => 6.12,
//            'position'      => 'portrait',
//            'filter'        => 'none'
//        ], [
//            'start_x_cm'    => 6.35,
//            'start_y_cm'    => 9.50,
//            'width_cm'      => 6.12,
//            'position'      => 'portrait',
//            'filter'        => 'none'
//        ], [
//            'start_x_cm'    => 6.35,
//            'start_y_cm'    => 0.00,
//            'width_cm'      => 6.12,
//            'position'      => 'portrait',
//            'filter'        => 'none'
//        ], [
//            'start_x_cm'    => 0.00,
//            'start_y_cm'    => 0.00,
//            'width_cm'      => 6.12,
//            'position'      => 'portrait',
//            'filter'        => 'none'
//        ]
//    ];
//
//        //set tmp folders
//        $cacheFolder = TMP . 'image-cache';
////        $fileName = md5($path);
////        $finalPath = IMAGES . 'cache' . DS . 'tmp' . DS . $fileName;
//        $imageHandlerMaster = new ImageHandler();
//        $imageHandlerMaster->create(850, 1250);
//        $iRatio = 67;
//        $aDone = array();
//        $sTmpDir = $cacheFolder . DS . 'tmp-images' . DS ;
//        
//        
//        //compile the compinationsheet
//        foreach($layout1 as $i => $aProductLayout) {
//            $sTmpTargetFile = microtime(true) . '.jpg';
//            $sImageName = $aProductLayout['position'] . '-' . $aProductLayout['filter'];
//            if( !key_exists($sImageName, $aDone ) ) {
//                $oTmpImageHandler = new ImageHandler();
//                $oTmpImageHandler->load($path);
//
//                $tmpWidth = imagesx($oTmpImageHandler->image);
//                $tmpHeight = imagesy($oTmpImageHandler->image);
//
//                if($aProductLayout['position'] == 'landscape') {
//                        if($tmpWidth < $tmpHeight) $oTmpImageHandler->rotate();
//                } else if($aProductLayout['position'] == 'portrait') {
//                        if($tmpWidth > $tmpHeight) $oTmpImageHandler->rotate();
//                } 
//
//                if($aProductLayout['filter'] == 'black-white' ) $oTmpImageHandler->convertToBlackWhite();
//                if($aProductLayout['filter'] == 'sepia' ) $oTmpImageHandler->convertToSepia();
//                $aDone[$sImageName] = $oTmpImageHandler;
//            } else {
//                $oTmpImageHandler = $aDone[$sImageName];
//            }
//
//            if($aProductLayout['position'] == 'landscape' ) {
//                $oTmpImageHandler->resize(array('height' => ($aProductLayout['width_cm']*$iRatio)));
//            } else {
//                $oTmpImageHandler->resize(array('width' => ($aProductLayout['width_cm']*$iRatio)));
//            }
//
//            $oTmpImageHandler->save($sTmpDir . $sTmpTargetFile);
//            $tmpWidth = imagesx($oTmpImageHandler->image);
//            $tmpHeight = imagesy($oTmpImageHandler->image);
//            $imageHandlerMaster->merge(
//                $sTmpDir . $sTmpTargetFile, 
//                array(
//                        'x' => ($aProductLayout['start_x_cm']*$iRatio), 
//                        'y' => ($aProductLayout['start_y_cm']*$iRatio),
//                        'width' => $oTmpImageHandler->imageDetails['width'],
//                        'height' => $oTmpImageHandler->imageDetails['height']
//                )
//            );
////            @unlink($sTmpDir . $sTmpTargetFile);
//        }
//        
////        $imageHandlerMaster->show();die();
        
    }
}
