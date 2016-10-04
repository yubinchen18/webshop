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
 * Description of LoosePrint
 *
 * @author yubin
 */
class LoosePrint
{
    private $layouts = [];
    private $layoutsPath;
    
    public function __construct($layouts)
    {
        //index all LoosePrintLayout files in $path
        $this->layoutsPath = dirname(__FILE__) . DS . 'LoosePrintLayouts' . DS;
        $folder = new Folder($this->layoutsPath);
        $files = $folder->find('(^LoosePrintLayout\d+).php', true);
        natsort($files);
        
        //load all associated layouts
        if ($layouts == 'all') {
            foreach ($files as $file) {
                preg_match('#\d+#', $file, $match);
                $number = $match[0];
                $fullClassName = 'App\Lib\Products\LoosePrintLayouts\LoosePrintLayout'.$number;
                $loosePrintLayout = new $fullClassName();
                $this->layouts['LoosePrintLayout'.$number] = $loosePrintLayout->getLayout();
            }
        //load specific layout
        } else {
            $file = $layouts.'.php';
            if (in_array($file, $files)) {
                $fullClassName = 'App\Lib\Products\LoosePrintLayouts\\'.$layouts;
                $loosePrintLayout = new $fullClassName();
                $this->layouts[$layouts] = $loosePrintLayout->getLayout();
            } else {
                throw new \Exception('You have to specify a valid LoosePrintLayout name.');
            }
        }
    }
    
    public function getLayouts()
    {
        return $this->layouts;
    }
}
