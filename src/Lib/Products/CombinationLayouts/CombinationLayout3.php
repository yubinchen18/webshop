<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Lib\Products\CombinationLayouts;

use App\Lib\Products\CombinationLayouts\Layout;

/**
 * Description of Combination3
 *
 * @author yubin
 */
class CombinationLayout3 extends Layout
{
    //put your code here
    public $name = 'CombinationLayout3';
    protected $data = [
        [
            'start_x_cm'    => 0.00,
            'start_y_cm'    => 0.00,
            'width_cm'      => 8.50,
            'position'      => 'landscape',
            'filter'        => 'none'
        ], [
            'start_x_cm'    => 0.00,
            'start_y_cm'    => 9.00,
            'width_cm'      => 8.50,
            'position'      => 'landscape',
            'filter'        => 'none'
        ]
    ];
}
