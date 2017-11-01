<?php

/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 31/10/2017
 * Time: 20:08
 */
namespace App\DataFixtures\ORM;

use App\Entity\Patronage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PatronageFixtures extends Fixture
{
    /**
     * feed db with all needed data on first launch
     * create an admin
     * create topics
     * create patronages
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        //create patronages
        $patronageList = [
            'ngo',
            'company',
            'town hall',
            'county',
            'association',
            'private investor',
        ];

        foreach ($patronageList as $key => $value)
        {
            $patronage = new Patronage();
            $patronage->setOrganization($value);
            $manager->persist($patronage);
        }

        $manager->flush();
    }
}

