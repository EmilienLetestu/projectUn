<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 04/01/2018
 * Time: 10:46
 */

namespace App\Action;

use App\Entity\User;
use App\Form\AskNewPswdType;
use App\Responder\LostPasswordResponder;
use App\Services\Mail;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LostPasswordAction
{
    private $formFactory;
    private $mailService;
    private $swift;
    private $session;
    private $urlGenerator;

    /**
     * LostPasswordAction constructor.
     * @param FormFactoryInterface $formFactory
     * @param Mail $mailService
     * @param \Swift_Mailer $swift
     * @param SessionInterface $session
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        FormFactoryInterface   $formFactory,
        Mail                   $mailService,
        \Swift_Mailer          $swift,
        SessionInterface       $session,
        UrlGeneratorInterface  $urlGenerator
    )
    {
        $this->formFactory  = $formFactory;
        $this->mailService  = $mailService;
        $this->swift        = $swift;
        $this->session      = $session;
        $this->urlGenerator = $urlGenerator;

    }

    /**
     * @param Request $request
     * @param LostPasswordResponder $responder
     * @return RedirectResponse|Response
     */
    public function __invoke(Request $request, LostPasswordResponder $responder)
    {
        $user = new User();
        $form = $this->formFactory
                     ->create(AskNewPswdType::class, $user)
                     ->handleRequest($request)
        ;

        if($form->isSubmitted() && $form->isValid())
        {
            //check if mail exist
            $user=$this->mailService->checkMailAvailability($user->getEmail());

            if(!$user) {
                $this->session
                     ->getFlashBag()
                     ->add('denied','Unknown email address')
                ;
                return $responder($form->createView());
            }

            //prepare email and send it
            $message = $this->mailService->newPswdMail(
                $user->getName(),
                $user->getSurname(),
                $user->getConfirmationToken(),
                $user->getEmail(),
                "lost_password@climateStories.com"
            );
            $this->swift->send($message);

            $this->session
                ->getFlashBag()
                ->add('success','A reset e-mail was sent to you, check your mailbox !')
            ;

            return new RedirectResponse(
                $this->urlGenerator
                     ->generate('home')
            );
        }

        return $responder($form->createView());
    }
}

