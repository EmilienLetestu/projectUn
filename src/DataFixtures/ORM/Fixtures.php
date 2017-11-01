<?php

/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 31/10/2017
 * Time: 20:08
 */
namespace App\DataFixtures\ORM;
use App\Entity\Patronage;
use App\Entity\Topic;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class Fixtures extends Fixture
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
        //create admin
        $user = new User();
        $user->setEmail('');
        $user->setName('');
        $user->setSurname('');
        $user->setActivated(true);
        $user->setPswd('');
        $user->setRole('ADMIN');
        $user->setConfirmationToken(40);
        $user->setRegisteredOn('Y-m-d');
        $manager->persist($user);

        //create topics
        $topicList = [
            'human settlements',
            'ocean',
            'water',
            'energy',
            'agriculture',
            'forests',
            'industries'
        ];
        foreach ($topicList as $key => $value)
        {
            $topic = new Topic();
            $topic->setType($value);
            $manager->persist($topic);
        }

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

