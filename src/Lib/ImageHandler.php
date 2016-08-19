<?php
/**
 * This class helps you to resize images
 *
 * @author Berry Goudswaard
 * @version 0.3
 * @since 29 September 2010
 */

namespace App\Lib;

use Cake\ORM\TableRegistry;
use App\Lib\Products\CombinationSheet;
use App\Model\Entity\Photo;

class ImageHandler
{
   /**
    * The controller that uses the component
    *
    * @var Controller
    */
    public $controller;

    /**
    * The original image that is loaded
    *
    * @var resource
    */
    public $originalImage;

    /**
     * The details of the original image
     *
     * @var array
     */
    public $originalImageDetails;

    /**
    * The resized image that is generated
    *
    * @var resource
    */
    public $image;

    /**
     * The details of the image
     *
     * @var array
     */
    public $imageDetails;

    /**
    * A list of allowed mime types
    *
    * @var array
    */
    public $allowedMimeTypes = array(
            'image/gif',
            'image/jpeg',
            'image/pjpeg',
            'image/png'
    );

    /**
    * The default options
    *
    * @var array
    */
    public $defaultOptions = array(
            'width' => null,
            'height' => null,
            'keepAspectRatio' => true,
    );
    
    /**
     * The path to cacheFolder to store cache images
     * @var type
     */
    public $cacheFolder;
    
    /**
     *  
     * @var type PhotoTable object
     */
    public $photos;

    public function __construct()
    {
        $this->cacheFolder = TMP . 'image-cache' . DS;
        $this->photos = TableRegistry::get('Photos');
    }
    
    private function getPhotoDetails($photoId)
    {
        $photo = $this->photos->find()
            ->where(['Photos.id' => $photoId])
            ->contain(['Barcodes'])
            ->first();
        if (!empty($photo)) {
            return $photo;
        } else {
            throw new \Exception('Photo not found.');
        }
    }

    private function __clone()
    {
        if (!empty($this->originalImage)) {
            $originalImage = imagecreatetruecolor($this->originalImageDetails['width'], $this->originalImageDetails['height']);
            imagecopyresampled($originalImage, $this->originalImage, 0, 0, 0, 0, $this->originalImageDetails['width'], $this->originalImageDetails['height'], $this->originalImageDetails['width'], $this->originalImageDetails['height']);

            $image = imagecreatetruecolor($this->imageDetails['width'], $this->imageDetails['height']);
            imagecopyresampled($image, $this->image, 0, 0, 0, 0, $this->imageDetails['width'], $this->imageDetails['height'], $this->imageDetails['width'], $this->imageDetails['height']);

            $this->originalImage = $originalImage;
            $this->image = $image;
        }
    }

    public function create($width, $height)
    {
        $image = imagecreatetruecolor($width, $height);
        imagefill($image, 0, 0, imagecolorallocate($image, 255, 255, 255));

        $this->originalImage = $image;
        $this->originalImageDetails = $originalImageDetails = array(
            'width' => $width,
            'height' => $height,
            'bits' => 8,
            'mime' => 'image/jpeg'
        );

        $this->image = $this->originalImage;

        $this->_setImageDetails();
        return $this->image;
    }

    private function ___createPhoto($photoId, $options = array())
    {
        $photoDetails = $this->getPhotoDetails($photoId);
        $photoFolder = $this->getPhotoFolder($photoDetails['Photo']['barcode_id']);

        extract($options);
        $use = isset($use) ? $use : 'big';

        if ($use != 'big') {
            $imagePath = $photoFolder . DS . 'med' . DS .  $photoDetails['Photo']['path'];
        } else {
            $imagePath = $photoFolder . DS .  $photoDetails['Photo']['path'];
        }
        return $imagePath;
    }


    public function createProductPreview(Photo $photo, $productGroup, array $options = null)
    {
        // Get the product and photo details.
        $photoFolder = $this->photos->getPath($photo->barcode_id) . DS;
        
//        // Check if there is a static product image.
//        $staticProductImage = current($productDetails['Image']);
//        if (!empty($staticProductImage['path']) && is_file(IMAGES . 'products' . DS .$staticProductImage['path'])) {
//            return IMAGES . 'products' . DS . $staticProductImage['path'];
//        }

        //Initialize variables and create the folders we need.
        $layout = 'all';
        $watermark = false;
        $tmpDir = $this->cacheFolder . 'tmp-images' . DS ;
        $tmpProductDir = WWW_ROOT . 'img' . DS . 'cache' . DS . 'tmp' . DS;
        $fileName = '';
        $suffix = null;
        $finalProductImages = [];
        $this->_createDir($tmpDir);
        $this->_createDir($tmpProductDir);

        //read the options
        if (isset($options) && is_array($options)) {
            foreach ($options as $option => $value) {
                if (!in_array((string)$option, ['resize', 'watermark', 'layout'])) {
                    throw new \Exception('Invalid Option'); die();
                }
                switch($option) {
                    case 'resize':
                        extract($value);
                        $width = isset($width) ? $width : null;
                        $height = isset($height) ? $height : null;
                        $suffix = $suffix . (string)$width.(string)$height;
                        break;
                    case 'watermark':
                        $watermark = isset($value) ? $value : false;
                        $suffix = $suffix . (($watermark == true) ? 'watermarked' : '');
                        break;
                    case 'layout' :
                        $layout = isset($value) ? $value : 'all';
                        break;
                }
            }
        }
        //load the productgroup layout files
        switch ($productGroup) {
            case 'combination-sheets':
                $combinationSheet = new CombinationSheet($layout);
                $productLayouts = $combinationSheet->getLayouts();
                break;
            case 'mug':
                break;
            default:
                throw new \Exception('You have to specify a valid product');
        }
        
        foreach ($productLayouts as $layoutName => $layout) {
            
            //give cached image path if already exists.
            if (!isset($suffix)) {
                $suffix = 'none';
            }
            $fileName = $layoutName . '-' . $photo->id . '-' . $suffix;
            $targetImage = $tmpProductDir . md5($fileName) . '.jpg';
            if( file_exists( $targetImage ) ) {
                $finalProductImages[] = ['layout' => $layoutName, 'path' => $targetImage, 'suffix' => $suffix];
                continue;
            }

            //create new blank canvas
            $ratio = 67;
            $this->create(850, 1250);
            $done = [];
            
            //loop through layout to add subimages to canvas
            foreach ($layout as $subImage) {
                $tmpTargetFile = microtime(true) . '.jpg';
                $imageName = $subImage['position'] . '-' . $subImage['filter'];
                if (!key_exists($imageName, $done)) {
                    $tmpImageHandler = new ImageHandler();
                    $tmpImageHandler->load($photoFolder . 'med' . DS . $photo->path);

                    $tmpWidth = imagesx($tmpImageHandler->image);
                    $tmpHeight = imagesy($tmpImageHandler->image);

                    if ($subImage['position'] == 'landscape') {
                        if ($tmpWidth < $tmpHeight) {
                            $tmpImageHandler->rotate();
                        }
                    } elseif ($subImage['position'] == 'portrait') {
                        if ($tmpWidth > $tmpHeight) {
                            $tmpImageHandler->rotate();
                        }
                    }

                    if ($subImage['filter'] == 'black-white') {
                        $tmpImageHandler->convertToBlackWhite();
                    }
                    if ($subImage['filter'] == 'sepia') {
                        $tmpImageHandler->convertToSepia();
                    }

                    $done[$imageName] = $tmpImageHandler;
                } else {
                    $tmpImageHandler = $done[$imageName];
                }

                if ($subImage['position'] == 'landscape') {
                    $tmpImageHandler->resize(array('height' => ($subImage['width_cm']*$ratio)));
                } else {
                    $tmpImageHandler->resize(array('width' => ($subImage['width_cm']*$ratio)));
                }

                $tmpImageHandler->save($tmpDir . $tmpTargetFile);
                $tmpWidth = imagesx($tmpImageHandler->image);
                $tmpHeight = imagesy($tmpImageHandler->image);

                $this->merge(
                    $tmpDir . $tmpTargetFile,
                    array(
                        'x' => ($subImage['start_x_cm']*$ratio),
                        'y' => ($subImage['start_y_cm']*$ratio),
                        'width' => $tmpImageHandler->imageDetails['width'],
                        'height' => $tmpImageHandler->imageDetails['height']
                    )
                );
                
                //delete tmp files
                @unlink($tmpDir . $tmpTargetFile);
            }

            //rotate class photos
            if (count($productLayouts) == 1 && $photo->type == 'class') {
                $this->rotate(-90);
            }

            //resize
            if (!empty($height) || !empty($width)) {
                $this->resize(
                    array(
                        'width' => $width,
                        'height' => $height
                    )
                );
            }
            
            // apply watermark
            if ($watermark) {
                $this->merge(APP . 'userphotos' . DS . 'watermark.png');
            }
            
            //save file to new location
            $this->save($targetImage);
            $finalProductImages[] = ['layout' => $layoutName, 'path' => $targetImage, 'suffix' => $suffix];
        }
        return $finalProductImages;
    }

    public function combine($images = array())
    {
        $combinedImage = imagecreatetruecolor(imagesx($images[0]['image']) * 2, imagesy($images[0]['image']) * 2);
        foreach ($images as $image) {
            imagecopyresampled($combinedImage, $image['image'], $image['offsetLeft'], $image['offsetTop'], 0, 0, $this->imageDetails['width'], $this->imageDetails['height'], imagesx($images[0]['image']), imagesy($images[0]['image']));
        }

        $this->image = $combinedImage;
    }

    public function convertToBlackWhite()
    {
        imagefilter($this->image, IMG_FILTER_GRAYSCALE);
        return $this->image;
    }


    public function convertToSepia()
    {
        $hex = '#704214';
        //strip #
        $hex = ltrim($hex, '#');
        //shift RGB values
        $dec    = hexdec($hex);
        $r = $dec >> 16 & 0xFF;
        $g = $dec >> 8 & 0xFF;
        $b = $dec & 0xFF;

        //dimensions:
        $w = $this->imageDetails['width'];
        $h = $this->imageDetails['height'];

        //new resource
        $new     = imagecreatetruecolor($w, $h);
        //center color
        $c = ($r+$g+$b)/3;
        //container
        $t = array();

        //create pallet
        $i =0;
        while ($i < 256) {
            $nr = ($i <= $c) ? (($i / $c) * $r) : (255 - ((255 - $i) / (255 - $c) * (255 - $r)));
            $ng = ($i <= $c) ? (($i / $c) * $g) : (255 - ((255 - $i) / (255 - $c) * (255 - $g)));
            $nb = ($i <= $c) ? (($i / $c) * $b) : (255 - ((255 - $i) / (255 - $c) * (255 - $b)));
            $t[$i] = imagecolorallocate($new, $nr, $ng, $nb);
            $i++;
        }
        //pixel dance, loop all pixels and change them
        $x=0;
        while ($x < $w) {
            $y = 0;
            while ($y < $h) {
                $rgb = imagecolorat($this->image, $x, $y);

                //$a = ($rgb >> 24) << 1; WRONG!
                $a = $rgb >> 24 & 0x7F;
                $r = $rgb >> 16 & 0xFF;
                $g = $rgb >> 8 & 0xFF;
                $b = $rgb & 0xFF;
                $bw = ($r+$g+$b)/3;
                imagesetpixel($new, $x, $y, $t[$bw]);
                $y++;
            }
            $x++;
        }
        //copy new
        $this->image = $new;
        //free memory
        //imagedestroy will not work because of reference.
        //unset is faster anyway too!
        unset($new);

        return $this->image;
    }

    public function merge($mergeImage, $options = array())
    {
        extract($options);
        $height = isset($height) ? $height : $this->imageDetails['height'];
        $width = isset($width) ? $width : $this->imageDetails['width'];


        $tmpImageHandler = new ImageHandler();
        $tmpImageHandler->load($mergeImage);
        $tmpImageHandler->resize(compact('width', 'height'));



        $x = isset($x) ? $x : ($this->imageDetails['width'] - $tmpImageHandler->imageDetails['width'])/2;
        $y = isset($y) ? $y : ($this->imageDetails['height'] - $tmpImageHandler->imageDetails['height'])/2;

        imagecopyresampled(
            $this->image,                               // Destination image
            $tmpImageHandler->image,                    // Source image
            $x,                                         // Destination X
            $y,                                         // Destination Y
            0,                                          // Source X
            0,                                          // Source Y
            $tmpImageHandler->imageDetails['width'],    // Destination width
            $tmpImageHandler->imageDetails['height'],   // Destination height
            $tmpImageHandler->imageDetails['width'],    // Source width
            $tmpImageHandler->imageDetails['height']    // Source height
        );

        return $this->image;
    }

    /**
     * Loads an image
     *
     * @param string $imagePath
     * @return void
     */
    public function load($imagePath)
    {
        $imageData = $this->_loadImage($imagePath);

        $this->originalImage = $imageData['image'];
        $this->originalImageDetails = $imageData['imageDetails'];
        $this->image = $this->originalImage;

        $this->_setImageDetails();
        return $this->image;
    }

    /**
     * Resizes an image
     *
     * @return void
     */
    public function resize($options = array())
    {
        $this->_checkImage();

        // Create options
        $options = array_merge($this->defaultOptions, $options);
        extract($options);

        // Check if the width or the height is given
        if (empty($width) && empty($height)) {
            trigger_error('No width or height given for resize', E_USER_ERROR);
        }

        // Calculate the new size
        $newImageSize = $this->_calculateImageSize($options);

        $this->image = $this->_createImage($newImageSize);

        $this->_setImageDetails();
        return $this->image;
    }

    /**
     *
     * Rotate an image
     * @param $degrees
     */
    public function rotate($degrees = 90)
    {
        $this->_checkImage();

        $this->image = imagerotate($this->image, $degrees, 0);

        $this->_setImageDetails();
        return $this->image;
    }

    /**
     * Show the image
     *
     * @return void
     */
    public function show()
    {
        switch ($this->originalImageDetails['mime']) {
            case 'image/gif':
                    header('Content-type: image/gif');
                    imagegif($this->image);
                break;
            case 'image/jpeg':
            case 'image/pjpeg':
                    header('Content-type: image/jpeg');
                    imagejpeg($this->image);
                break;
            case 'image/png':
                    header('Content-type: image/png');
                    imagepng($this->image);
                break;
            break;
        }
    }


    /**
     * Show the image
     *
     * @return void
     */
    public function save($path)
    {
        if (!is_dir(dirname($path))) {
            $this->_createDir(dirname($path));
        }
        switch ($this->originalImageDetails['mime']) {
            case 'image/gif':
                imagegif($this->image, $path);
                break;
            case 'image/jpeg':
            case 'image/pjpeg':
                imagejpeg($this->image, $path, 100);
                break;
            case 'image/png':
                imagepng($this->image, $path);
                break;
            break;
        }

        if (is_file($path)) {
            @chmod($path, 0777);
        }
    }

    private function _createDir($path)
    {
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
            $tmpPath = $path;
            $i = 0;
            while (TMP !== $tmpPath) {
                chmod($tmpPath, 0777);
                $tmpPath = dirname($tmpPath) . DS;
                $i++;
                if ($i > 10) {
                    break;
                }
            }
        }
    }

    /**
    * Creates the image
    *
    * @return resource
    */
    private function _createImage($newImageSize)
    {
        $resizedImage = imagecreatetruecolor($newImageSize['width'], $newImageSize['height']);

        if ($this->imageDetails['mime'] == 'image/png') {
            imagealphablending($resizedImage, false);
            imagesavealpha($resizedImage, true);
            //imageantialias($resizedImage, true);
        }

        imagecopyresampled($resizedImage, $this->image, 0, 0, 0, 0, $newImageSize['width'], $newImageSize['height'], $this->imageDetails['width'], $this->imageDetails['height']);
        return $resizedImage;
    }

    /**
     * Calculate the new size for the image
     *
     * @return array
     */
    private function _calculateImageSize($options = array())
    {
        // Create options
        $options = array_merge($this->defaultOptions, $options);
        extract($options);

        $originalSize = array('width' => $this->imageDetails['width'], 'height' => $this->imageDetails['height']);
        $originalShape = $this->imageDetails['shape'];

        // If just one of the dimensions has a value, the calculation is the same no mather what the value of $keepAspectRatio is
        if (!empty($width) && empty($height)) {
            return array('width' => $width, 'height' => round($originalSize['height']/($originalSize['width']/$width)) );
        }
        if (empty($width) && !empty($height)) {
            return array('width' => round($originalSize['width']/($originalSize['height']/$height)), 'height' => $height );
        }

        // If both dimensions are have a value the calculation differs based on the value of $keepAspectRatio
        if (!empty($width) && !empty($height)) {
            $newShape = 'portrait';
            if ($originalSize['width'] > $originalSize['height']) {
                $newShape = 'landscape';
            }
            if ($originalSize['width'] == $originalSize['height']) {
                $newShape = 'square';
            }

            if ($keepAspectRatio) {
                if ($newShape == 'portrait') {
                    $newHeight = $height;
                    $newWidth = round($originalSize['width']/($originalSize['height']/$newHeight));
                    if ($newWidth > $width) {
                        $newWidth = $width;
                        $newHeight = round($originalSize['height']/($originalSize['width']/$newWidth));
                    }
                    return array('width' => $newWidth, 'height' => $newHeight);
                }

                if ($newShape == 'landscape') {
                    $newWidth = $width;
                    $newHeight = round($originalSize['height']/($originalSize['width']/$newWidth));

                    if ($newHeight > $height) {
                        $newHeight = $height;
                        $newWidth = round($originalSize['width']/($originalSize['height']/$newHeight));
                    }
                    return array('width' => $newWidth, 'height' => $newHeight);
                }
            }

            return array('width' => $width, 'height' => $height);
        }
    }

    /**
     * Checks if the is an image loaded
     *
     * @return void
     */
    private function _checkImage()
    {
        if ($this->originalImage == null) {
            trigger_error('There is no image loaded. Please call the method \'load\' first', E_USER_ERROR);
        }
    }


    private function _loadImage($imagePath)
    {
        // Check if the file exists
        if (!file_exists($imagePath)) {
            trigger_error('The file \'' . $imagePath . '\' does not exist', E_USER_ERROR);
        }

        // Check if the mime type is allowed
        $originalImageDetails = getimagesize($imagePath);
        if (!in_array($originalImageDetails['mime'], $this->allowedMimeTypes)) {
            trigger_error('The mime type of the file \'' . $imagePath . '\' is not allowed', E_USER_ERROR);
        }

        // Create the image
        switch ($originalImageDetails['mime']) {
            case 'image/gif':
                $originalImage = imagecreatefromgif($imagePath);
                break;
            case 'image/jpeg':
            case 'image/pjpeg':
                $originalImage = imagecreatefromjpeg($imagePath);
                break;
            case 'image/png':
                $originalImage = imagecreatefrompng($imagePath);
                imagesavealpha($originalImage, true);
                break;
            break;
        }

        // Set the details of the original image
        $originalImageDetails = array(
            'width' => $originalImageDetails[0],
            'height' => $originalImageDetails[1],
            'bits' => $originalImageDetails['bits'],
            'mime' => $originalImageDetails['mime']
        );

        $originalImageDetails['shape'] = 'portrait';
        if ($originalImageDetails['width'] > $originalImageDetails['height']) {
            $originalImageDetails['shape'] = 'landscape';
        }
        if ($originalImageDetails['width'] == $originalImageDetails['height']) {
            $originalImageDetails['shape'] = 'square';
        }

        return array(
            'image' => $originalImage,
            'imageDetails' => $originalImageDetails
        );
    }

    private function _setImageDetails()
    {
        $this->imageDetails = array(
            'width' => imagesx($this->image),
            'height' => imagesy($this->image),
            'bits' => $this->originalImageDetails['bits'],
            'mime' => $this->originalImageDetails['mime']
        );

        $this->imageDetails['shape'] = 'portrait';
        if ($this->imageDetails['width'] > $this->imageDetails['height']) {
            $this->imageDetails['shape'] = 'landscape';
        }
        if ($this->imageDetails['width'] == $this->imageDetails['height']) {
            $this->imageDetails['shape'] = 'square';
        }
    }

    public function createProduct($sourcePath, $product, $layouts = 'all')
    {
        switch ($product) {
            case 'combination':
                $CombinationSheet = new CombinationSheet($sourcePath, $layouts);
                return $CombinationSheet->getLayouts();
                break;
            case 'mug':
                break;
            default:
                throw new \Exception('You have to specify a product');
        }
    }
}
