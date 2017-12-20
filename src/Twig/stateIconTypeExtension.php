<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 20/12/2017
 * Time: 09:48
 */

namespace App\Twig;


class stateIconTypeExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return[
           new \Twig_SimpleFilter('stateIcon',[$this,'stateIconFilter'])
        ];
    }

    public function stateIconFilter($state)
    {
        return $state == 1 ?
            'fa fa-check' : 'fa fa-times'
        ;
    }
}