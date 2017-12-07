<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/12/2017
 * Time: 11:52
 */

namespace App\Managers;


use App\Entity\Notification;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class NotificationManager
{
    private $doctrine;
    private $session;
    private $token;

    /**
     * NotificationManager constructor.
     * @param EntityManager $doctrine
     * @param Session $session
     * @param TokenStorage $token
     */
    public function __construct(
        EntityManager $doctrine,
        Session       $session,
        TokenStorage  $token
    )
    {
        $this->doctrine = $doctrine;
        $this->session  = $session;
        $this->token    = $token;
    }

    /**
     * Add notification to db for a given user
     * @param $type
     * @param User $user
     */
    public function notifyUser($type,User $user)
    {
        $date = date('Y-m-d');
        \DateTime::createFromFormat('Y-m-d',$date);

        $notification = new Notification();
        $notification->setType($type);
        $notification->setSeen(false);
        $notification->setUser($user);
        $notification->setNotifiedOn(\DateTime::createFromFormat('Y-m-d',$date));

        $this->doctrine->getRepository(Notification::class);
        $this->doctrine->persist($notification);
    }

    public function getNotificationForUser()
    {
        if(!$this->session->get('checkNotif'))
        {
            $repository = $this->doctrine->getRepository(Notification::class);

            $user = $this->token->getToken()->getUser();

           $notificationList = $repository->findNotificationForUser(
                $user->getId(),
                0
           );

           $this->session->set('checkNotif',1);
           $this->updateNotificationStatus($notificationList);

           return $notificationList;
        }
    }

    /**
     * Set all notification to "seen"
     * @param $notificationList
     */
    public function updateNotificationStatus($notificationList)
    {
        foreach ($notificationList as $notification)
        {
            $notification->setSeen(1);

            $this->doctrine->persist($notification);
        }

        $this->doctrine->flush();
    }

    /**
     * @param User $user
     */
    public function chooseNotification(User $user)
    {
        return  $user->getBeenProcessed()=== false  ?
            $this->approvalNotification($user) :
            $this->upDateNotification($user)
            ;
    }

    /**
     * @param User $user
     */
    public function upDateNotification(User $user)
    {
        $type = $user->getRole() === 'EDIT' ? 1 : 2;
        $this->notifyUser($type,$user);

        return $this->doctrine->persist($user);
    }

    /**
     * @param User $user
     */
    public function approvalNotification(User $user)
    {
        $type = $user->getRole() === 'EDIT' ? 4 : 3;
        $this->notifyUser($type,$user);
        $user->setBeenProcessed(true);

        return $this->doctrine->persist($user);
    }
}