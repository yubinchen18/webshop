<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Lib\Products\LoosePrintLayouts;

use App\Lib\Products\LoosePrintLayouts\Layout;

/**
 * Description of LoosePrint1
 *
 * @author yubin
 */
class LoosePrintLayout1 extends Layout
{
    //put your code here
    public $name = 'LoosePrintLayout1';
    protected $data = [
        [
            'start_x_cm'    => 0.00,
            'start_y_cm'    => 0.00,
            'width_cm'      => 13.00,
            'position'      => 'portrait',
            'filter'        => 'none'
        ]
    ];
}
