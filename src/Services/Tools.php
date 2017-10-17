<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 17/10/17
 * Time: 10:32
 */

namespace App\Services;


class Tools
{
    /**
     * @param $date
     * @return bool
     * check if generated link as expired
     */
    public function isLinkStillValid($date)
    {
        $today = new \DateTime();
        $dateFromLink = new \DateTime($date);
        $diff = $dateFromLink->diff($today)->days;

        return $diff < 2 ? true : false;
    }
}