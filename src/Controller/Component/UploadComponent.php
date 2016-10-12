<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Utility\Text;

/**
 * Upload component
 */
class UploadComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    
    public function avatarUpload($data = null, $createThumbnail = true)
    {
        if ($data ['error'] == 4) {
            return false;
        }
        $file_tmp_name = $data['tmp_name'];
        $allowed = ['jpg', 'jpeg', 'png', 'bmp'];
        if (!in_array(pathinfo($data['name'], PATHINFO_EXTENSION), $allowed)) {
            return false;
        }
        if (file_exists(!$data)) {
            return false;
        }
        if (!is_uploaded_file($file_tmp_name)) {
            return false;
        };
        $filename = Text::uuid().'_'.$data['name'];
        if (move_uploaded_file($file_tmp_name, $filename)) {
            if ($createThumbnail) {
                $data['filename'] = $filename;
                $this->create($data);
            }
            return $filename;
            pr('yo');
            die();
        }
        return false;
    }
    
    public function create($data)
    {
        $maxsize = 250;
        $dir = APP . 'userphotos'.DS.'userProfilePhoto' .DS;
        $allowed = ['jpeg', 'jpg', 'png', 'bmp'];

        $pathinfo = pathinfo($data['filename']);
        $destination = $dir.$pathinfo['basename'];
        
        if (file_exists($destination)) {
            return true;
        } else {
            if (!in_array(pathinfo($data['filename'], PATHINFO_EXTENSION), $allowed)) {
                echo '<p>File does not have the right extension!</p>';
                return false;
            } else {
                // Afm. origineel ophalen.
                list($width_orig, $height_orig) = getimagesize($data['filename']);

                // Bepalen nieuwe afmetingen:
                if ($width_orig < $maxsize && $height_orig < $maxsize) {
                    $height = $height_orig;
                    $width = $width_orig;
                } elseif ($width_orig < $height_orig) {
                    $height = $maxsize;
                    $width = round(($maxsize / $height_orig) * $width_orig);
                } else {
                    $height = round(($maxsize / $width_orig) * $height_orig);
                    $width = $maxsize;
                }
                // Resize
                switch (strtolower($pathinfo['extension'])) {
                    case 'png':
                        $source = imagecreatefrompng($data['filename']);
                        break;
                    case 'jpg':
                        $source = imagecreatefromjpeg($data['filename']);
                        break;
                    case 'jpeg':
                        $source = imagecreatefromjpeg($data['filename']);
                        break;
                    case 'bmp':
                        $source = imagecreatefrombmp($data['filename']);
                        break;
                    default:
                        return false;
                }
                $thumb = imagecreatetruecolor($width, $height);
                imagecopyresampled($thumb, $source, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

                switch (strtolower($pathinfo['extension'])) {
                    case 'png':
                        return imagepng($thumb, $destination);
                        break;
                    case 'jpg':
                        return imagejpeg($thumb, $destination);
                        break;
                    case 'jpeg':
                        return imagejpeg($thumb, $destination);
                        break;
                    case 'bmp':
                        return imagebmp($thumb, $destination);
                        break;
                }
            }
        }
        return false;
    }
}
