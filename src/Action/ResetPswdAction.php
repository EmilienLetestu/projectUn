<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 04/01/2018
 * Time: 11:14
 */

namespace App\Action;

use App\Entity\User;
use App\Form\NewPswdType;
use App\Responder\ResetPswdResponder;
use App\Services\Mail;
use App\Services\Tools;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class ResetPswdAction
{
    private $formFactory;
    private $doctrine;
    private $mailService;
    private $tools;
    private $swift;
    private $session;

    /**
     * ResetPswdAction constructor.
     * @param FormFactoryInterface $formFactory
     * @param EntityManager $doctrine
     * @param Mail $mailService
     * @param Tools $tools
     * @param \Swift_Mailer $swift
     * @param Session $session
     */
    public function __construct(
        FormFactoryInterface   $formFactory,
        EntityManager          $doctrine,
        Mail                   $mailService,
        Tools                  $tools,
        \Swift_Mailer          $swift,
        Session                $session
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
     * @param ResetPswdResponder $responder
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request, ResetPswdResponder $responder)
    {
        //get url parameter
        $expireDate = $request->attributes->get('expireOn');
        $email      = $request->attributes->get('email');
        $token      = $request->attributes->get('token');

        //check if data from db match url
        $repository = $this->doctrine->getRepository(User::class);
        $user       = $repository->findOneBy([
            'email'              => $email,
            'confirmationToken'  => $token
        ]);

        if(!$user) {
            $this->session
                ->getFlashBag()
                ->add('denied', 'Unknown email address')
            ;
            return new RedirectResponse('/');
        }

        //check if mail still valid
        $stillValid = $this->tools->isLinkStillValid($expireDate);

        if($stillValid === false) {
            $this->session
                ->getFlashBag()
                ->add('denied', 'Expired link, a new one has been sent to you')
            ;
            //prepare email and send it
            $message = $this->mailService->newPswdMail(
                $user->getName(),
                $user->getSurname(),
                $user->getConfirmationToken(),
                $user->getEmail(),
                "lost_password@climateStories.com"
            );
            $this->swift->send($message);
            return new RedirectResponse('/');
        }

        //generate form
        $form = $this->formFactory
                     ->create(NewPswdType::class, $user)
                     ->handleRequest($request)
        ;

        if($form->isSubmitted() && $form->isValid())
        {
            $user->setPswd($form->get('pswd')->getData());
            $this->doctrine->flush();

            $this->session
                ->getFlashBag()
                ->add('success', 'Password changed')
            ;

            return new RedirectResponse('/');
        }

        return $responder($form->createView());
    }
}

