<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 16/10/17
 * Time: 12:20
 */

namespace App\Services;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;

class Register
{
    private $formFactory;
    private $doctrine;
    private $swift;
    private $mailService;
    private $session;

    /**
     * Register constructor.
     * @param FormFactory $formFactory
     * @param EntityManager $doctrine
     * @param \Swift_Mailer $swift
     * @param Session $session
     * @param Mail $mailService
     */
    public function __construct(
        FormFactory   $formFactory,
        EntityManager $doctrine,
        \Swift_Mailer $swift,
        Session       $session,
        Mail          $mailService
    )
    {
        $this->formFactory  = $formFactory;
        $this->doctrine     = $doctrine;
        $this->swift        = $swift;
        $this->session      = $session;
        $this->mailService  = $mailService;
    }

    public function registerUser(Request $request)
    {
        $user = new User();
        $registerForm = $this->formFactory->create(RegisterType::class,$user);

        $registerForm->handleRequest($request);

        if($registerForm->isSubmitted() && $registerForm->isValid())
        {

            $emailInDb = $this->mailService
                ->checkMailAvailability($user->getEmail())
            ;

            if ($emailInDb !== null)
            {
                $this->session->getFlashBag()
                    ->add('denied',
                        'This email is already used'
                    )
                ;
                return $registerForm->createView();
            }

            //hydrate with submitted data
            $user->setRegisteredOn('Y-m-d');
            $user->setRole('user');
            $user->setConfirmationToken(40);
            $registerForm->get('claimEdit')->getData() === 1 ?
                $user->setBeenProcessed(false) :
                $user->setBeenProcessed(true)
            ;

            //prepare email
            $message = $this->mailService->validationMail(
                $user->getName(),
                $user->getSurname(),
                $user->getConfirmationToken(),
                $user->getEmail(),
                "activation@climateStories.com"
            );

            //save
            $this->doctrine->persist($user);
            $this->doctrine->flush();

            //send validation email
            $this->swift->send($message);

            $this->session->getFlashBag()
                ->add('success',
                    'Account created ! An activation email has been sent to you '
                )
            ;

            return 'home';
        }

        return $registerForm->createView();
    }
}
