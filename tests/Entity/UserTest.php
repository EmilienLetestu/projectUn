<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 17/10/17
 * Time: 11:27
 */

namespace tests\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class UserTest extends TestCase
{
    public function testUser()
    {
        //generate tested object
        $user = new User();

        //create test data
        $name = "emilien";
        $surname ="Lestestu";
        $email  = "eletestu@gmail.com";
        $password = "testpasword1714";
        $role = "USER";
        $registedOn = "Y-m-d";
        $tokenLenth = 40;


        //hydrate with test data
        $user->setName($name);
        $user->setSurname($surname);
        $user->setEmail($email);
        $user->setPswd($password);
        $user->setRole($role);
        $user->setRegisteredOn($registedOn);
        $user->setConfirmationToken($tokenLenth);

        //generate expected date
        $today = new \DateTime(date('Y-m-d'));
        $hash  = $user->getPassword();

        //test
        static::assertEquals('Emilien',$user->getName());
        static::assertEquals($surname,$user->getSurname());
        static::assertEquals($email,$user->getEmail());
        static::assertTrue(password_verify($password,$hash));
        static::assertEquals($role,$user->getRole());
        static::assertEquals($today,$user->getRegisteredOn());
        static::assertEquals(40, strlen($user->getConfirmationToken()));
        static::assertEquals(false,$user->getActivated());
        static::assertEquals(false,$user->getDeactivated());
        static::assertTrue($user->isAccountNonExpired());
        static::assertTrue($user->isAccountNonLocked());
        static::assertFalse($user->isEnabled());
        static::assertEquals(["ROLE_USER"],$user->getRoles());
    }
}