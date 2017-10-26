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
    private $requestStack;
    private $doctrine;
    private $swift;
    private $mailService;
    private $session;

    public function __construct(
        FormFactory   $formFactory,
        RequestStack  $requestStack,
        EntityManager $doctrine,
        \Swift_Mailer $swift,
        Session       $session,
        Mail          $mailService
    )
    {
        $this->formFactory  = $formFactory;
        $this->requestStack = $requestStack;
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
            ;


            //prepare email
            $message = $this->mailService->validationMail(
                $user->getName(),
                $user->getSurname(),
                $user->getConfirmationToken(),
                $user->getEmail(),
                $sender = "activation@climateStories.com"
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

            return $redirect = 'home';
        }

        return $registerForm->createView();
    }
}