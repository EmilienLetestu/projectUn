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
    /**
     * @return array
     */
    public function getFilters()
    {
        return[
           new \Twig_SimpleFilter('stateIcon',[$this,'stateIconFilter'])
        ];
    }

    /**
     * @param $state
     * @return string
     */
    public function stateIconFilter($state)
    {
        return $state == 1 || $state === 'published' ?
            'fa fa-check' : 'fa fa-times'
        ;
    }
}