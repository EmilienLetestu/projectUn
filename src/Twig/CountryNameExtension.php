<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 12/10/17
 * Time: 21:11
 */

namespace App\Twig;

use Symfony\Component\Intl\Intl;

class CountryNameExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('country',[$this, 'countryFilter'])
        ];
    }

    public function countryFilter($isoCode)
    {
      return  $country = Intl::getRegionBundle()->getCountryName($isoCode);
    }




}