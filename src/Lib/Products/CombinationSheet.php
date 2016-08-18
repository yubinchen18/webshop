<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Lib\Products;

use Cake\Filesystem\Folder;
use App\Lib\ImageHandler;

/**
 * Description of CombinationSheet
 *
 * @author yubin
 */
class CombinationSheet 
{
    private $layouts = [];
    private $layoutsPath;
    private $combinationSheets;
    
    public function __construct($layouts)
    {
        //index all CombinationLayout files in $path
        $this->layoutsPath = dirname(__FILE__) . DS . 'CombinationLayouts' . DS;
        $folder = new Folder($this->layoutsPath);
        $files = $folder->find('(^CombinationLayout\d+).php', true);
        
        //load all associated layouts
        if ($layouts == 'all') {
            foreach ($files as $file) {
                preg_match('#\d+#', $file, $match);
                $number = $match[0];
                $fullClassName = 'App\Lib\Products\CombinationLayouts\CombinationLayout'.$number;
                $combinationLayout = new $fullClassName();
                $this->layouts['CombinationLayout'.$number] = $combinationLayout->getLayout();
            }
        //load specific layout 
        } else {
            $file = $layouts.'.php';
            if (in_array($file, $files)) {
                $fullClassName = 'App\Lib\Products\CombinationLayouts\\'.$layouts;
                $combinationLayout = new $fullClassName();
                $this->layouts[$layouts] = $combinationLayout->getLayout();
            } else {
                throw new \Exception('You have to specify a valid CombinationLayout name.');
            }
        }
        
//        return $this->createCombinationSheet($sourcePath, $this->layouts);
        // if all, alle types aanmaken
        // als naam van layout: alleen die layout
        // new Image(hoogte, breedte);
        // Image = buitenste image
        // foreach subimage (dus in layout)
        // new Image(hoogte, breedte);
        // Image->setBlackWhite();
        
        // return is array van strings met path naar aangemaakte image
        // key = layoutname
    }
    
    public function createCombinationSheet($sourcePath, $layouts)
    {
        //create array with images paths
        if (file_exists($sourcePath)) {
            pr($layouts);
            foreach ($layouts as $key => $layout) {
                
            }
        }
    }
    
    public function getLayouts()
    {
        return $this->layouts;
    }
}
