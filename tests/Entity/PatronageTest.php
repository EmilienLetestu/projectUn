<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 15/10/17
 * Time: 19:20
 */

namespace tests\Entity;

use App\Entity\Patronage;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class PatronageTest extends TestCase
{
    public function testPatronage()
    {
        //test 1 data
        $organization = 'association';
        $identity     = 'my association';

        // create object
        $patronage = new Patronage();

        //hydrate with test data
        $patronage->setOrganization($organization);
        $patronage->setIdentity($identity);

        // process test 1
        static::assertEquals($organization,$patronage->getOrganization());
        static::assertEquals($identity,$patronage->getIdentity());

        //test 2 data
        //simulate submit value from a choices list to test private function "displayOrganizationName"
        $organization = 1;
        $result = 'ong' ;

        //hydrate with test data
        $patronage->setOrganization($organization);

        //process test 2
        static::assertEquals($result,$patronage->getOrganization($organization));

    }
}