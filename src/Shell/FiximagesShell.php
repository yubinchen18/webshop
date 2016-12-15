<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;

/**
 * Fiximages shell command.
 */
class FiximagesShell extends Shell
{

    /**
     * Manage the available sub-commands along with their arguments and help
     *
     * @see http://book.cakephp.org/3.0/en/console-and-shells.html#configuring-options-and-generating-help
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser()
    {
        $parser = parent::getOptionParser();

        return $parser;
    }

    /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function main() 
    {
        $photosTable = TableRegistry::get('Photos');

        $photos = $photosTable->find()->toArray();
        foreach($photos as $photo) {
            $path = $photosTable->getPath($photo['barcode_id']);
            $photoPath = $path . DS . basename($photo['path']);
            if (file_exists($photoPath)) {
                $pic = new \Imagick($photoPath);
                $photosTable->autoRotateImage($pic);
            }
        }
        exit;
    }
}
