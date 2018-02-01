<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 01/11/2017
 * Time: 15:04
 */

namespace App\DataFixtures\ORM;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
class UserFixtures extends Fixture
{
    /**
     * feed db with all needed data on first launch
     * create an admin
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        //create admin
        $user = new User();
        $user->setEmail('admin@un.org');
        $user->setName('John');
        $user->setSurname('Doe');
        $user->setActivated(true);
        $user->setPswd('unAdmin1854');
        $user->setRole('ADMIN');
        $user->setConfirmationToken(40);
        $user->setRegisteredOn('Y-m-d');
        $user->setClaimEdit(false);
        $user->setBeenProcessed(true);
        $user->setDeactivated(false);
        $user->setProfession(null);
        $user->setEngagement(null);
        $manager->persist($user);
        $manager->flush();
    }
}


