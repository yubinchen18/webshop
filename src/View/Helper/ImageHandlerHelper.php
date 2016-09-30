<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use App\Lib\ImageHandler;

/**
 * ImageHandler helper
 */
class ImageHandlerHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    
    public $helpers = ['Html', 'Url'];
    
    public function createProductPreview($photo, array $options = [])
    {
        $imageHandler = new ImageHandler();
        $combinationSheetThumb = $imageHandler->createProductPreview($photo, 'combination-sheets', [
            'resize' => ['width' => 200, 'height' => 180],
            'watermark' => false,
            'layout' => 'CombinationLayout1'
        ]);
        return $this->Html->image($this->Url->build([
            'controller' => 'Photos',
            'action' => 'displayProduct',
            'layout' => $combinationSheetThumb[0]['layout'],
            'id' => $photo->id,
            'suffix' => $combinationSheetThumb[0]['suffix']
        ]), $options);
    }
}
