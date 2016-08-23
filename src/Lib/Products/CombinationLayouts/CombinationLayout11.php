<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Lib\Products\CombinationLayouts;

use App\Lib\Products\CombinationLayouts\Layout;

/**
 * Description of Combination11
 *
 * @author yubin
 */
class CombinationLayout11 extends Layout
{
    //put your code here
    public $name = 'CombinationLayout11';
    protected $data = [
        [
            'start_x_cm'    => 0.00,
            'start_y_cm'    => 9.50,
            'width_cm'      => 6.12,
            'position'      => 'portrait',
            'filter'        => 'none'
        ], [
            'start_x_cm'    => 6.35,
            'start_y_cm'    => 9.50,
            'width_cm'      => 6.12,
            'position'      => 'portrait',
            'filter'        => 'none'
        ], [
            'start_x_cm'    => 6.35,
            'start_y_cm'    => 0.00,
            'width_cm'      => 6.12,
            'position'      => 'portrait',
            'filter'        => 'none'
        ], [
            'start_x_cm'    => 0.00,
            'start_y_cm'    => 0.00,
            'width_cm'      => 6.12,
            'position'      => 'portrait',
            'filter'        => 'none'
        ]
    ];
}
