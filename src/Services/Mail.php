<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 16/10/17
 * Time: 14:07
 */
namespace App\Services;

use App\Entity\User;
use Doctrine\ORM\EntityManager;


class Mail
{
    private $twig;
    private $doctrine;

    /**
     * Mail constructor.
     * @param \Twig_Environment $twig
     * @param EntityManager $doctrine
     */
    public function __construct(
        \Twig_Environment $twig,
        EntityManager     $doctrine

    )
    {
        $this->twig     = $twig;
        $this->doctrine = $doctrine;
    }

    /**
     * @param $email
     * @return mixed
     */
    public function checkMailAvailability($email)
    {
        $repository = $this->doctrine->getRepository(User::class);

        return  $repository->findOneByEmail($email);
    }

    /**
     * @param $name
     * @param $surname
     * @param $token
     * @param $email
     * @param $sender
     * @return \Swift_Message
     */
    public function validationMail($name,$surname,$token,$email,$sender)
    {
        $message = (new \Swift_Message('Account activation'));
        $message
            ->setFrom($sender)
            ->setTo($email)
            ->setBody($this->twig->render('validationMail.html.twig', [
                'name'     => $name,
                'surname'  => $surname,
                'token'    => $token,
                'email'    => $email,
                'expireOn' => date('Y-m-d', strtotime('+2 day'))
            ]),
                'text/html');
        return $message;
    }

    /**
     * @param $name
     * @param $surname
     * @param $token
     * @param $email
     * @param $sender
     * @return \Swift_Message
     */
    public function newPswdMail($name,$surname,$token,$email,$sender)
    {
        $message = (new \Swift_Message('lost password'));
        $message
            ->setFrom($sender)
            ->setTo($email)
            ->setBody($this->twig->render('newPswdMail.html.twig', [
                'name'    => $name,
                'surname' => $surname,
                'token'   => $token,
                'email'   => $email,
                'expireOn'=> date('Y-m-d', strtotime('+2 day'))
            ]),
                'text/html'
            )
        ;
        return $message;
    }

    /**
     * @param $name
     * @param $surname
     * @param $email
     * @param $sender
     * @param $role
     * @return \Swift_Message
     */
    public function updatedRoleMail($name,$surname,$email,$sender,$role)
    {
        $message = (new \Swift_Message('updated privileges'));
        $message
            ->setFrom($sender)
            ->setTo($email)
            ->setBody($this->twig->render('updatedRole.html.twig', [
                'name'    => $name,
                'surname' => $surname,
                'role'    => $role,
            ]),
                'text/html'
            )
        ;
        return $message;
    }

    /**
     * @param $name
     * @param $surname
     * @param $email
     * @param $sender
     * @param $role
     * @param $profession
     * @param $engagement
     * @return \Swift_Message
     */
    public function deniedRoleMail(
        $name,
        $surname,
        $email,
        $sender,
        $role,
        $profession,
        $engagement
    )
    {
        $message = (new \Swift_Message('denied privileges'));
        $message
            ->setFrom($sender)
            ->setTo($email)
            ->setBody($this->twig->render('updatedRole.html.twig', [
                'name'       => $name,
                'surname'    => $surname,
                'role'       => $role,
                'profession' => $profession,
                'engagement' => $engagement
            ]),
                'text/html'
            )
        ;
        return $message;
    }
}
