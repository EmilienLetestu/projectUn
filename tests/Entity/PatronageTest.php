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

        // create object
        $patronage = new Patronage();

        //hydrate with test data
        $patronage->setOrganization($organization);

        // process test 1
        static::assertEquals($organization,$patronage->getOrganization());

    }
}