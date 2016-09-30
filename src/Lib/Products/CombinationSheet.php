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
    
    public function __construct($layouts)
    {
        //index all CombinationLayout files in $path
        $this->layoutsPath = dirname(__FILE__) . DS . 'CombinationLayouts' . DS;
        $folder = new Folder($this->layoutsPath);
        $files = $folder->find('(^CombinationLayout\d+).php', true);
        natsort($files);
        
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
    }
    
    public function getLayouts()
    {
        return $this->layouts;
    }
}
