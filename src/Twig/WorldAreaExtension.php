<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 04/12/2017
 * Time: 19:57
 */

namespace App\Twig;


class WorldAreaExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('worldArea',[$this,'worldAreaFilter'])
        ];
    }

    public function worldAreaFilter($code)
    {

        $worldArea = [
           '1' =>  'Africa',
           '2' =>  'Asia',
           '3' =>  'Europe',
           '4' =>  'North America',
           '5' =>  'South America',
           '6' =>  'Oceania'
        ];

        return $worldArea[$code];
    }
}
