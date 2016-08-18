<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Lib\Products\CombinationLayouts;

use App\Lib\Products\CombinationLayouts\Layout;

/**
 * Description of Combination5
 *
 * @author yubin
 */
class CombinationLayout5 extends Layout {
    //put your code here
    public $name = 'CombinationLayout5';
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
            'width_cm'      => 3.15,
            'position'      => 'portrait',
            'filter'        => 'none'
        ], [
            'start_x_cm'    => 3.15,
            'start_y_cm'    => 9.00,
            'width_cm'      => 3.15,
            'position'      => 'portrait',
            'filter'        => 'none'
        ], [
            'start_x_cm'    => 6.30,
            'start_y_cm'    => 9.00,
            'width_cm'      => 3.15,
            'position'      => 'portrait',
            'filter'        => 'none'
        ], [
            'start_x_cm'    => 9.45,
            'start_y_cm'    => 9.00,
            'width_cm'      => 3.15,
            'position'      => 'portrait',
            'filter'        => 'none'
        ], [
            'start_x_cm'    => 0.50,
            'start_y_cm'    => 14.00,
            'width_cm'      => 3.75,
            'position'      => 'landscape',
            'filter'        => 'none'
        ], [
            'start_x_cm'    => 7.00,
            'start_y_cm'    => 14.00,
            'width_cm'      => 3.75,
            'position'      => 'landscape',
            'filter'        => 'none'
        ]
    ];
}
