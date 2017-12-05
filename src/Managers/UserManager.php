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

    public function __construct(
        EntityManager $doctrine,
        Session       $session
    )
    {
        $this->doctrine = $doctrine;
        $this->session  = $session;
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

        $this->doctrine->flush();

       return $this->session->getFlashBag()
           ->add('succes',
            $user->getFullname().'User has been granted '.$user->getRole().' privileges'
           )
      ;
    }
}