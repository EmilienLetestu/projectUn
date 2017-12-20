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
     * @return mixed
     */
    public function updateUserRole($id)
    {
        $repository = $this->doctrine->getRepository(User::class);
        $user= $repository->find($id);

        if($user->getRole() === 'ADMIN')
        {
           return $this->session->getFlashBag()
               ->add('denied',
                   'you can\'t update administrator privileges'
               )
           ;
        }

        $user->getRole() === 'EDIT' ?
            $user->setRole('USER') :
            $user->setRole('EDIT')
        ;

        $this->notification->chooseNotification($user);

        $this->doctrine->flush();

       return $this->session->getFlashBag()
           ->add('succes',
            $user->getFullname().'User has been granted '.$user->getRole().' privileges'
           )
      ;
    }

    /**
     * @return array
     */
    public function fetchUserForAdmin()
    {
        $repository = $this->doctrine->getRepository(User::class);
        return $repository->findAll();
    }
}

