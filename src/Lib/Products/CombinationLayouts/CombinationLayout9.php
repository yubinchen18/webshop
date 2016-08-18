<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Lib\Products\CombinationLayouts;

use App\Lib\Products\CombinationLayouts\Layout;

/**
 * Description of Combination9
 *
 * @author yubin
 */
class CombinationLayout9 extends Layout {
    //put your code here
    public $name = 'CombinationLayout9';
    protected $data = [
        [
            'start_x_cm'    => 0.06,
            'start_y_cm'    => 9.40,
            'width_cm'      => 6.12,
            'position'      => 'portrait',
            'filter'        => 'black-white'
        ], [
            'start_x_cm'    => 6.47,
            'start_y_cm'    => 9.40,
            'width_cm'      => 6.12,
            'position'      => 'portrait',
            'filter'        => 'sepia'
        ], [
            'start_x_cm'    => 6.47,
            'start_y_cm'    => 0.06,
            'width_cm'      => 6.12,
            'position'      => 'portrait',
            'filter'        => 'none'
        ], [
            'start_x_cm'    => 0.06,
            'start_y_cm'    => 0.06,
            'width_cm'      => 6.12,
            'position'      => 'portrait',
            'filter'        => 'none'
        ]
    ];
}
