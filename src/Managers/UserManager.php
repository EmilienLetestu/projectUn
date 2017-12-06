<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 05/12/2017
 * Time: 16:08
 */

namespace App\Managers;


use App\Entity\User;
use App\Services\Mail;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;

class UserManager
{
    private $doctrine;
    private $session;
    private $mailService;
    private $swift;

    public function __construct(
        EntityManager $doctrine,
        Session       $session,
        Mail          $mailService,
        \Swift_Mailer $swift

    )
    {
        $this->doctrine    = $doctrine;
        $this->session     = $session;
        $this->mailService = $mailService;
        $this->swift       = $swift;
    }


    /**
     * @param $id
     * @return mixed
     */
    public function updateUserRole($id)
    {
        $user = $this->doctrine->getRepository(User::class)
            ->find($id)
        ;

        if($user->getRole === 'ADMIN')
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

        if ($user->getBeenProcessed() === 0)
        {
            $user->setBeenProcessed(1);
        }

        $this->doctrine->flush();

        $mail = $this->mailService->updatedRoleMail(
                $user->getName(),
                $user->getSurname(),
                $user->getEmail(),
                'admin@climateStories.com',
                $user->getRole()
        );

       $this->swift->send($mail);

       return $this->session->getFlashBag()
           ->add('succes',
            $user->getFullname().'User has been granted '.$user->getRole().' privileges'
           )
      ;
    }


}
