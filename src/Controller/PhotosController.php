<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Filesystem\Folder;
use Cake\Network\Exception\NotFoundException;
use App\Lib\ImageHandler;
use Imagick;

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
        //load persons for allow auth check
        $persons = $this->getAllLoggedInUsers();

        //add the orientation data to the photos array
        if (!empty($persons)) {
            $group_ids = [];
            foreach ($persons as $person) {
                foreach ($person->barcode->photos as $key => $photo) {
                    $filePath = $this->Photos->getPath($person->barcode_id) . DS . $photo->path;
                    list($width, $height) = getimagesize($filePath);
                    $photo->orientationClass = ($width > $height) ? 'photos-horizontal' : 'photos-vertical';
                    
                    $person->groupPhotos = $this->Photos->find('groupPhotos', ['group_id' => $person->group_id]);
                    
                    foreach ($person->groupPhotos as $groupphoto) {
                        $filePath = $this->Photos->getPath($groupphoto->barcode_id) . DS . $groupphoto->path;
                        list($width, $height) = getimagesize($filePath);
                        $groupphoto->orientationClass = ($width > $height) ? 'photos-horizontal' : 'photos-vertical';
                    }
                }
                $person->showGroupPhoto = $this->addGroupPicturesToView($group_ids, $person->group_id);
                $group_ids[] = $person->group_id;
            }
        } else {
            $this->Flash->error(__('Person not found.'));
        }
        $this->set(compact('persons'));
        $this->set('_serialize', ['photos']);
    }
    
    private function addGroupPicturesToView($group_ids, $group_id)
    {
        foreach($group_ids as $id) {
            if ($id == $group_id) {
                return false;
            }
        }
        return true;
    }
    
    private function getAllLoggedInUsers()
    {
        $loggedInUsersIds = $this->request->session()->read('LoggedInUsers.AllUsers');

        $persons = [];
        foreach ($loggedInUsersIds as $userId) {
            $person = $this->Photos->Barcodes->Groups->Persons->find()
                ->where(['Persons.user_id' => $userId])
                ->contain(['Barcodes.Photos'])
                ->first();
            if ($person) {
                $persons[] = $person;
            }
        }
        
        return $persons;
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
        $photo = $this->Photos->find()
                ->where(['Photos.id' => $id])
                ->contain(['Barcodes.Persons'])
                ->first();
        
        if (empty($photo->id)) {
            throw new NotFoundException('De foto kon niet worden gevonden');
        }
        
        if ($this->isAuthForPhoto($photo)) {
            //add the orientation data to the photos array
            $filePath = $this->Photos->getPath($photo->barcode_id) . DS . $photo->path;

            list($width, $height) = getimagesize($filePath);
            if ($width > $height) {
                $orientationClass = 'photos-horizontal';
            } else {
                $orientationClass = 'photos-vertical';
            }
            $photo->orientationClass = $orientationClass;

            $this->set(compact('photo'));
            $this->set('_serialize', ['photo']);
        } else {
            throw new NotFoundException('Not authorized to view this photo');
        }
    }

    private function isAuthForPhoto($photo)
    {
        $loggedInUsersIds = $this->request->session()->read('LoggedInUsers.AllUsers');
        if ($photo->type === 'group' || $photo->type == 'class') {
            $enabledGroups = [];
            foreach ($loggedInUsersIds as $user_id) {
                $enabledGroups[] = $this->Photos->Barcodes->Persons
                        ->find()
                        ->select(['Groups.id'])
                        ->contain(['Groups'])
                        ->where(['Persons.user_id' => $user_id])
                        ->hydrate(false)
                        ->first();
            }
            $enabledGroups = Hash::extract($enabledGroups, "{n}.Groups.id");
            $photo = $this->Photos->get($photo->id, ['contain' => 'Barcodes.Groups']);
            return in_array($photo->barcode->group->id, $enabledGroups);
        }
        
        return in_array($photo->barcode->person->user_id, $loggedInUsersIds);
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
    public function productGroupIndex($productGroup, $photoId, $filter = null)
    {
        $this->autoRender = false;
        //load the photo
            $photo = $this->Photos->find()
                ->where(['Photos.id' => $photoId])
                ->contain(['Barcodes.Persons'])
                ->firstOrFail();
        
        if (!empty($photo)) {
            if ($this->isAuthForPhoto($photo)) {
                //load products
                $productTable = TableRegistry::get('Products');
                $products = $productTable->find()
                        ->where(['product_group' => $productGroup])
                        ->andWhere(['slug !=' => 'gratis_afdruk_13x18'])
                        ->contain(['Productoptions.ProductoptionChoices'])
                        ->orderAsc('article')
                        ->toArray();
                $photo->orientationClass = $this->Photos->returnPhotoOrientation($photo);
                $photo->selectedProduct = $this->request->params['productGroup'];
                
                if (!empty($products)) {
                    foreach ($products as $product) {
                        //create tmp product preview images
                        $imageHandler = new ImageHandler();
                        $image = $imageHandler->createProductPreview($photo, $product->product_group, [
                            'resize' => ['width' => 200, 'height' => 180],
                            'layout' => !empty($product->layout) ? $product->layout : 'all',
                            'filter' => $filter
                        ]);
                        //add the image data to product object
                        if ($product->product_group !== 'funproducts') {
                            $product->image = $image[0];
                        }
                    }
                } else {
                    throw new NotFoundException('No products found.');
                }
                
                //pass results to views
                $templateName = $productGroup.'-index';
                if ($this->request->is('ajax')) {
                    $templateName = 'product_group_index';
                }
                $this->set(compact('photo', 'products', 'digitalProduct', 'digitalPack'));
                $this->set('_serialize', ['images']);
                $this->render($templateName);
            } else {
                throw new NotFoundException('Not authorized to view this photo');
            }
        } else {
            throw new NotFoundException('Photo not found');
        }
    }
    
    public function digitalIndex()
    {
        $persons = $this->getDigitalPhotos();
        $productsTable = TableRegistry::get('Products');
        $cartsTable = TableRegistry::get('Carts');
        $cart = $cartsTable->checkExistingCart($this->Auth->user('id'));
        $cart = $cartsTable->updatePrices($cart->id);
        $digitalDiscounts = $cart->digitalDiscounts;
        $digitalPage = true;
        
        if (!empty($persons)) {
            foreach ($persons as $person) {
                foreach ($person->barcode->photos as $photo) {
                    //create tmp product preview images for each photo in cache
                    $products = $productsTable->find()
                        ->where(['product_group' => 'digital'])
                        ->contain(['Productoptions.ProductoptionChoices'])
                        ->orderAsc('article')
                        ->toArray();

                    if (!empty($products)) {
                        foreach ($products as $product) {
                            //create tmp product preview images
                            $imageHandler = new ImageHandler();
                            $image = $imageHandler->createProductPreview($photo, $product->product_group, [
                                'resize' => ['width' => 200, 'height' => 180],
                                'layout' => !empty($product->layout) ? $product->layout : 'all',
                            ]);
                            $product->image = $image[0];
                        }
                    } else {
                        throw new NotFoundException('No products found.');
                    }
                }
            }
        } else {
            $this->Flash->error(__('Person not found.'));
        }
        
        
        $firstPhoto = $persons[0]->barcode->photos[0];
        $this->set(compact('persons', 'products', 'firstPhoto', 'digitalDiscounts', 'digitalPage'));
    }
    
    public function deleteCartLine($id)
    {
        $this->Cartlines = TableRegistry::get('Cartlines');
        $line = $this->Cartlines->find()
                ->where(['id' => $id])
                ->first();
        $this->Cartlines->delete($line);
    }
    
    public function changeFreeGroupsPicture($personBarcode = null)
    {
        $this->setFreeGroupsPictureSettings($personBarcode, "changeFreeGroupsPicture");
    }
    
    public function pickFreeGroupsPicture($personBarcode = null)
    {
        $this->setFreeGroupsPictureSettings($personBarcode, "pickFreeGroupsPicture");
    }
    
    private function setFreeGroupsPictureSettings($personBarcode = null, $layout = null)
    {
        //check if barcode is a person
        $this->Persons = TableRegistry::get('Persons');
        $person = $this->Persons->find()
            ->contain(['Groups'])
            ->where(['Persons.barcode_id' => $personBarcode])
            ->first();
        
        $photos = $this->Photos->getGroupPictures($person->group->barcode_id);
        if (!empty($photos)) {
            foreach ($photos as $photo) {
                if ($this->isAuthForPhoto($photo)) {
                    //add the orientation data to the photos array
                    $photo->orientationClass = $this->Photos->returnPhotoOrientation($photo);
                } else {
                    throw new NotFoundException('Not authorized to view this photo');
                }
            }
        }
        
        //get free product
        $this->Products = TableRegistry::get('Products');
        $product = $this->Products->find()
            ->where(['article' => 'GAF 13x19'])
            ->first();
        
        $this->set(compact('photos', 'product', 'personBarcode'));
        $this->set('_serialize', ['photos']);
        $this->render($layout);
    }
    
    private function getDigitalPhotos()
    {
        $persons = $this->getAllLoggedInUsers();
        if (!empty($persons)) {
            foreach ($persons as $person) {
                foreach ($person->barcode->photos as $key => $photo) {
                    $photo->orientationClass = $this->Photos->returnPhotoOrientation($photo);
                    $photo->portrait = TableRegistry::get('Users')->getUserPortrait($person->user_id);
                }
            }
            return $persons;
        } else {
            $this->Flash->error(__('Person not found.'));
        }
    }
}
