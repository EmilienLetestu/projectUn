<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 13/11/2017
 * Time: 12:04
 */

namespace App\Twig;


class NotificationTypeExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('typeToText',[$this,'notificationFilter'])
        ];
}

    public function notificationFilter($type)
    {
        $list = [
            '1'=>'Your privileges has been upgraded, you\'ve been granted access to our stories edition tool' ,
            '2'=>'Your privileges has been downgraded, you can\'t edit stories anymore',
            '3'=>'Your access request to our stories edition tool has been approved',
            '4'=>'Your access request to our stories edition tool has been denied'
        ];

        return $list[$type];

    }
}
