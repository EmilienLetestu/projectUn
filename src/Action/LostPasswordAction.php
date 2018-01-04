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
use App\Services\Tools;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

final class LostPasswordAction
{
    private $formFactory;
    private $doctrine;
    private $mailService;
    private $tools;
    private $swift;
    private $session;

    /**
     * LostPasswordAction constructor.
     * @param FormFactoryInterface $formFactory
     * @param EntityManager $doctrine
     * @param Mail $mailService
     * @param Tools $tools
     * @param \Swift_Mailer $swift
     * @param Session $session
     */
    public function __construct(
        FormFactoryInterface   $formFactory,
        EntityManager $doctrine,
        Mail          $mailService,
        Tools         $tools,
        \Swift_Mailer $swift,
        Session       $session
    )
    {
        $this->formFactory  = $formFactory;
        $this->doctrine     = $doctrine;
        $this->mailService  = $mailService;
        $this->tools        = $tools;
        $this->swift        = $swift;
        $this->session      = $session;
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

            return new RedirectResponse('/');
        }

        return $responder($form->createView());
    }
}