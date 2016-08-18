<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Lib\Products\CombinationLayouts;

use App\Lib\Products\CombinationLayouts\Layout;

/**
 * Description of Combination1
 *
 * @author yubin
 */
class CombinationLayout1 extends Layout {
    //put your code here
    public $name = 'CombinationLayout1';
    protected $data = [
        [
            'start_x_cm'    => 6.30,
            'start_y_cm'    => 9.50,
            'width_cm'      => 6.30,
            'position'      => 'portrait',
            'filter'        => 'none'
        ], [
            'start_x_cm'    => 0.00,
            'start_y_cm'    => 9.50,
            'width_cm'      => 6.30,
            'position'      => 'portrait',
            'filter'        => 'none'
        ], [
            'start_x_cm'    => 6.30,
            'start_y_cm'    => 4.50,
            'width_cm'      => 4.30,
            'position'      => 'landscape',
            'filter'        => 'black-white'
        ], [
            'start_x_cm'    => 0.00,
            'start_y_cm'    => 0.00,
            'width_cm'      => 3.15,
            'position'      => 'portrait',
            'filter'        => 'none'
        ], [
            'start_x_cm'    => 3.15,
            'start_y_cm'    => 0.00,
            'width_cm'      => 3.15,
            'position'      => 'portrait',
            'filter'        => 'none'
        ], [
            'start_x_cm'    => 6.30,
            'start_y_cm'    => 0.00,
            'width_cm'      => 4.30,
            'position'      => 'landscape',
            'filter'        => 'sepia'
        ], [
            'start_x_cm'    => 0.00,
            'start_y_cm'    => 4.50,
            'width_cm'      => 3.15,
            'position'      => 'portrait',
            'filter'        => 'none'
        ], [
            'start_x_cm'    => 3.15,
            'start_y_cm'    => 4.50,
            'width_cm'      => 3.15,
            'position'      => 'portrait',
            'filter'        => 'none'
        ]
    ];
}
