<?php
namespace App\Controller\Supplier;

use App\Controller\AppController\Admin;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

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
    
    public function display($size, $id)
    {
        $photo = $this->Photos->find()
              ->where(['id' => $id])
              ->first();
        
        $file = $this->Photos
                ->getPath($photo->barcode_id) . DS . $size . DS . $photo->path;
        
        $this->response->type(['jpg' => 'image/jpeg']);
        $this->response->file($file, ['name' => 'path']);
        return $this->response;
    }
}
