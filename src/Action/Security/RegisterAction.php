<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 04/01/2018
 * Time: 09:42
 */

namespace App\Action\Security;


use App\Entity\User;
use App\Form\RegisterType;
use App\Responder\Security\RegisterResponder;
use App\Services\Mail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class RegisterAction
{
    private $formFactory;
    private $doctrine;
    private $swift;
    private $mailService;
    private $session;

    /**
     * RegisterAction constructor.
     * @param FormFactoryInterface $formFactory
     * @param EntityManagerInterface $doctrine
     * @param \Swift_Mailer $swift
     * @param SessionInterface $session
     * @param Mail $mailService
     */
    public function __construct(
        FormFactoryInterface   $formFactory,
        EntityManagerInterface $doctrine,
        \Swift_Mailer          $swift,
        SessionInterface       $session,
        Mail                   $mailService
    )
    {
        $this->formFactory  = $formFactory;
        $this->doctrine     = $doctrine;
        $this->swift        = $swift;
        $this->session      = $session;
        $this->mailService  = $mailService;
    }

    public function __invoke(Request $request, RegisterResponder $responder)
    {
        $user = new User();

        $form = $this->formFactory
                     ->create(RegisterType::class, $user)
                     ->handleRequest($request)
        ;

        if($form->isSubmitted() && $form->isValid())
        {
            $emailInDb = $this->mailService
                ->checkMailAvailability($user->getEmail())
            ;

            if ($emailInDb !== null)
            {
                $this->session
                     ->getFlashBag()
                     ->add('denied', 'This email is already used')
                ;
                return $responder($form->createView());
            }

            //hydrate with submitted data
            $user->setRegisteredOn('Y-m-d');
            $user->setRole('user');
            $user->setConfirmationToken(40);
            $form->get('claimEdit')->getData() == true ?
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

            $this->session
                 ->getFlashBag()
                 ->add('success', 'Account created ! An activation email has been sent to you ')
            ;

            return new RedirectResponse('/');
        }

        return $responder($form->createView());
    }


}