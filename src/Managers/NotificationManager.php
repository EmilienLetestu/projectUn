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
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class NotificationManager
{
    private $doctrine;
    private $session;
    private $token;
    private $authCheck;

    /**
     * NotificationManager constructor.
     * @param EntityManager $doctrine
     * @param Session $session
     * @param TokenStorage $token
     */
    public function __construct(
        EntityManager $doctrine,
        Session       $session,
        TokenStorage  $token,
        AuthorizationChecker $authCheck
    )
    {
        $this->doctrine = $doctrine;
        $this->session  = $session;
        $this->token    = $token;
        $this->authCheck = $authCheck;
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

    /**
     * get all notification for a given user just after login
     */
    public function getNotificationForUser()
    {
        if(!$this->session->get('notifList') && $this->authCheck->isGranted('ROLE_USER'))
        {
            $repository = $this->doctrine->getRepository(Notification::class);

            $user = $this->token->getToken()->getUser();

            $notificationList = $repository->findNotificationForUser(
                $user->getId(),
                0
            );

          $this->session->set('notifList',1);

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
        $type = $user->getRole() === 'EDIT' ? 3 : 4;
        $this->notifyUser($type,$user);
        $user->setBeenProcessed(true);

        return $this->doctrine->persist($user);
    }
}
