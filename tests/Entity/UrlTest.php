<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 18/01/2018
 * Time: 16:04
 */

namespace tests\Entity;


use App\Entity\Url;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class UrlTest extends TestCase
{
    public function urlTest()
    {
        $url = new Url();

        $href    = 'https://openclassrooms.com';
        $host    = 'openclassrooms.com';

        $url->setHref($href);
        $url->setAlt($href);

        //test
        static::assertEquals($href, $url->getHref());
        static::assertEquals($host, $url->getAlt());

    }
}

