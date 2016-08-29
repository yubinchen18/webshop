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
        $userId = $this->request->session()->read('Auth.User.id');

        $personsTable = TableRegistry::get('Persons');
        $person = $personsTable->find()
                ->where(['Persons.user_id' => $userId])
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
        $userId = $this->request->session()->read('Auth.User.id');
        
        //load the person and photo
        $personsTable = TableRegistry::get('Persons');
        $person = $personsTable->find()
                ->where(['Persons.user_id' => $userId])
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
                
                //create a thumbnail for combination sheets for the view
                $imageHandler = new ImageHandler();
                $combinationSheetThumb = $imageHandler->createProductPreview($photo, 'combination-sheets', [
                    'resize' => ['width' => 200, 'height' => 180],
                    'watermark' => false,
                    'layout' => 'CombinationLayout1'
                ]);
                $this->set(compact('person', 'photo', 'combinationSheetThumb'));
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
    
    /**
     *
     * @param type $layout
     * @param type $id
     * @return type
     */
    public function displayProduct($layout, $id, $suffix = null)
    {
        // look for temp product cache pics in hardcoded folders\
        $tmpProductDir = $this->request->query('path');
        $fileName = $layout . '-' . $id . '-' . $suffix;
        if (!$tmpProductDir) {
            $tmpProductDir = (new ImageHandler())->tmpProductImagesFolder;
        }
        $targetImage = $tmpProductDir . md5($fileName) . '.jpg';
        if (file_exists($targetImage)) {
            $this->response->type(['jpg' => 'image/jpeg']);
            $this->response->file($targetImage, ['name' => $fileName]);
            return $this->response;
        } else {
            throw new NotFoundException('Product photo was not found.');
        }
    }
    
    /**
     *
     * @param type $productGroup
     * @param type $photoId
     * @throws NotFoundException
     */
    public function productGroupIndex($productGroup, $photoId)
    {
        $this->autoRender = false;
        //check if user is auth to view this photo id
        $userId = $this->request->session()->read('Auth.User.id');

        //load the person and photo
        $personsTable = TableRegistry::get('Persons');
        $person = $personsTable->find()
                ->where(['Persons.user_id' => $userId])
                ->contain(['Barcodes'])
                ->first();
        
        if (!empty($person)) {
            $photo = $this->Photos->find()
                ->where(['Photos.id' => $photoId, 'Photos.barcode_id' => $person->barcode->id])
                ->contain(['Barcodes'])
                ->first();

            if (!empty($photo)) {
                //load products
                $productTable = TableRegistry::get('Products');
                $products = $productTable->find()
                        ->where(['product_group' => $productGroup])
                        ->orderAsc('article')
                        ->toArray();
                
                
                //add the orientation data to the photos array
                $filePath = $this->Photos->getPath($photo->barcode_id) . DS . $photo->path;
                $dimensions = getimagesize($filePath);
                if ($dimensions[0] > $dimensions[1]) {
                    $orientationClass = 'photos-horizontal';
                } else {
                    $orientationClass = 'photos-vertical';
                }
                $photo->orientationClass = $orientationClass;
                if (!empty($products)) {
                    //set thumbnail
                    $combinationSheetThumb = $products[0];
                    foreach ($products as $product) {
                        //create tmp product preview images
                        $imageHandler = new ImageHandler();
                        $image = $imageHandler->createProductPreview($photo, $product->product_group, [
                            'resize' => ['width' => 200, 'height' => 180],
                            'layout' => $product->layout
                        ]);
                        //add the image data to product object
                        $product->image = $image[0];
                    }
                } else {
                    throw new NotFoundException('No products found.');
                }
                //pass results to views
                $templateName = $productGroup.'-index';
                $this->set(compact('person', 'photo', 'products', 'combinationSheetThumb'));
                $this->set('_serialize', ['images']);
                $this->render($templateName);
            } else {
                throw new NotFoundException('Photo not found');
            }
        } else {
            throw new NotFoundException('Person not found');
        }
    }
}
