<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 05/12/2017
 * Time: 16:08
 */

namespace App\Managers;


use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class UserManager
{
    private $doctrine;
    private $session;
    private $notification;

    public function __construct(
        EntityManager        $doctrine,
        Session              $session,
        NotificationManager  $notification

    )
    {
        $this->doctrine     = $doctrine;
        $this->session      = $session;
        $this->notification = $notification;
    }

    /**
     * @param $id
     * @return string
     */
    public function upgradeUser($id)
    {
        $repository = $this->doctrine->getRepository(User::class);
        $user = $repository->find($id);

        $user->setRole('EDIT');
        $this->doctrine->persist($user);
        $this->notification->chooseNotification($user);
        $this->doctrine->flush();

        return $user->getFullname().'User has been granted editor privileges';
    }

    /**
     * @param $id
     * @return string
     */
    public function downgradeUser($id)
    {
        $repository = $this->doctrine->getRepository(User::class);
        $user = $repository->find($id);

        $user->setRole('USER');
        $this->doctrine->persist($user);
        $this->notification->chooseNotification($user);
        $this->doctrine->flush();

        return $user->getFullname().'User has been granted user privileges';
    }

    /**
     * @param $id
     * @return string
     */
    public function deleteUser($id)
    {
        $repository = $this->doctrine->getRepository(User::class);
        $user = $repository->find($id);

        $this->doctrine->remove($user);
        $this->doctrine->flush();

        return 'User account has been deleted';
    }

    /**
     * @return array
     */
    public function fetchUserForAdmin()
    {

        return $this->doctrine->getRepository(User::class)
            ->findAll()
         ;
    }

    /**
     * @param Request $request
     * @return null|object
     */
    public function fetchOneUserForAdmin(Request $request)
    {
        $repository = $this->doctrine->getRepository(User::class);

        return $repository->findOneBy([
            'id' => $request->attributes->get('id')
        ]);
    }

}

