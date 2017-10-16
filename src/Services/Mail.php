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

    private $mailer;
    private $twig;
    private $doctrine;

    /**
     * Mails constructor.
     * @param \Swift_Mailer $swift
     * @param \Twig_Environment $twig
     * @param EntityManager $doctrine
     */
    public function __construct(
        \Swift_Mailer     $swift,
        \Twig_Environment $twig,
        EntityManager     $doctrine

    )
    {
        $this->mailer   = $swift;
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
        $message = (new \Swift_Message('Activation de votre compte Nao'));
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
}