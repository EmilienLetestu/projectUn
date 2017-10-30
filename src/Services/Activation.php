<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 16/10/17
 * Time: 16:44
 */

namespace App\Services;


use App\Entity\User;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class Activation
{

    private $doctrine;
    private $session;
    private $mailService;
    private $tools;
    private $swift;


    /**
     * Activation constructor.
     * @param EntityManager $doctrine
     * @param Session $session
     * @param Mail $mailService
     * @param Tools $tools
     * @param \Swift_Mailer $swift
     */
    public  function __construct(
        EntityManager $doctrine,
        Session       $session,
        Mail          $mailService,
        Tools         $tools,
        \Swift_Mailer $swift

    )
    {
        $this->doctrine    = $doctrine;
        $this->session     = $session;
        $this->mailService = $mailService;
        $this->tools       = $tools;
        $this->swift       = $swift;

    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function activateUserAccount(Request $request)
    {
        //data to check from url
        $email = $request->attributes->get('email');
        $token = $request->attributes->get('token');
        $date  = $request->attributes->get('expireOn');

        //get user
        $repository = $this->doctrine->getRepository(User::class);
        $user       = $repository->findOneBy([
            'email'              => $email,
            'confirmationToken'  => $token
        ]);


        $stillValid = $this->tools->isLinkStillValid($date);

        if($stillValid === false)
        {
            //send another activation email
            $message = $this->mailService->validationMail(
                $user->getName(),
                $user->getSurname(),
                $user->getConfirmationToken(),
                $user->getEmail(),
                "activation@climateStories.com"
            );

            $this->swift->send($message);

            return $this->session->getFlashBag()
                ->add('denied','Expired link, a new one has been sent to you')
                ;
        }

        if(!$user)
        {
            return $this->session->getFlashBag()
                ->add('error','Unknown user')
                ;
        }

        $user->setActivated(true);
        $this->doctrine->flush();

        return $this->session->getFlashBag()
            ->add('success','Your account has been activated !')
            ;
    }
}
