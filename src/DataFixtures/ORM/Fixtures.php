<?php

/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 31/10/2017
 * Time: 20:08
 */
namespace App\DataFixtures\ORM;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class Fixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
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
        $manager->flush();
    }
}
