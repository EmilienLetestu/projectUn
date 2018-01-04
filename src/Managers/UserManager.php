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

        return $user->getFullname().' has been granted editor privileges';
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

        return $user->getFullname().' has been granted user privileges';
    }

    /**
     * @param $id
     * @return string
     */
    public function rejectUser($id)
    {
        $repository = $this->doctrine->getRepository(User::class);
        $user = $repository->find($id);
        $this->notification->chooseNotification($user);
        $this->doctrine->flush();

        return $user->getFullname().' stories edition tools access has been rejected';
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
     * @param $nDaysAgo
     * @return mixed
     */
    public function deleteAllUnactivatedAccount($nDaysAgo)
    {
        $repository = $this->doctrine->getRepository(User::class);
        $userList = $repository->findDeletableAccount($nDaysAgo);

        if(!$userList)
        {
            return $this->session->getFlashBag()
                ->add('error','No account to delete')
            ;
        }

        foreach ($userList as $user )
        {
            $this->doctrine->remove($user);
        }

        $this->doctrine->flush();

        return $this->session->getFlashBag()
            ->add('success','Successfully delete '. count($userList) .' unactivated account')
        ;
    }
}

