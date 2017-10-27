<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 17/10/17
 * Time: 10:30
 */

namespace App\Services;

use App\Entity\User;
use App\Form\AskNewPswdType;
use App\Form\NewPswdType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;


class RenewPswd
{
    private $formFactory;
    private $doctrine;
    private $requestStack;
    private $mailService;
    private $tools;
    private $swift;
    private $session;
    private $token;

    /**
     * UpdatePswd constructor.
     * @param FormFactory $formFactory
     * @param EntityManager $doctrine
     * @param RequestStack $requestStack
     * @param Mail $mailService
     * @param Tools $tools
     * @param \Swift_Mailer $swift
     * @param Session $session
     * @param TokenStorage $token
     */
    public function __construct(
        FormFactory   $formFactory,
        EntityManager $doctrine,
        RequestStack  $requestStack,
        Mail          $mailService,
        Tools         $tools,
        \Swift_Mailer $swift,
        Session       $session,
        TokenStorage  $token
    )
    {
        $this->formFactory  = $formFactory;
        $this->doctrine     = $doctrine;
        $this->requestStack = $requestStack;
        $this->mailService  = $mailService;
        $this->tools        = $tools;
        $this->swift        = $swift;
        $this->session      = $session;
        $this->token        = $token;
    }

    /**
     * Send an email to renew a lost password
     * @param Request $request
     * @return \Symfony\Component\Form\FormView
     */
    public function askNew(Request $request)
    {
        //generate needed object and form
        $user = new User();
        $askResetForm = $this->formFactory->create(AskNewPswdType::class, $user);
        $askResetForm->handleRequest($request);

        //process form
        if($askResetForm->isSubmitted() && $askResetForm->isValid())
        {
            //check if mail exist
            $user=$this->mailService->checkMailAvailability($user->getEmail());

            if(!$user)
            {
                $this->session->getFlashBag()
                    ->add('denied',
                        'Unknown email address'
                    )
                ;
                return $askResetForm->createView();
            }
            //prepare email and send it
            $message = $this->mailService->newPswdMail(
                $user->getName(),
                $user->getSurname(),
                $user->getConfirmationToken(),
                'eletestu@gmail.com'
            );
            $this->swift->send($message);
        }

        return $askResetForm->createView();
    }

    /**
     * @param Request $request
     * @return string|\Symfony\Component\Form\FormView
     */
    public function newPswd(Request $request)
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

        if(!$user)
        {
            $this->session->getFlashBag()
                ->add('denied',
                    'Unknown email address'
                )
            ;
            return $redirect = 'home';
        }

        //check if mail still valid
        $stillValid = $this->tools->isLinkStillValid($expireDate);

        if($stillValid === false)
        {
            $this->session->getFlashBag()
                ->add('denied',
                    'Expired link, a new one has been sent to you'
                )
            ;
            //prepare email and send it
            $message = $this->mailService->newPswdMail(
                $user->getName(),
                $user->getSurname(),
                $user->getConfirmationToken(),
                $user->getEmail(),
                $sender="lost_password@climateStories.com"
            );
            $this->swift->send($message);

            return $redirect = 'home';
        }

        //generate needed object and form
        $resetForm = $this->formFactory->create(NewPswdType::class, $user);
        $resetForm->handleRequest($request);

        //process form data
        if($resetForm->isSubmitted() && $resetForm->isValid())
        {
            //hydrate user object with new password
            $user->setPswd($resetForm->get('pswd')->getData());
            //store into db
            $this->doctrine->flush();

            //msg flash
            $this->session->getFlashBag()
                ->add('success',
                    'Password changed'
                )
            ;

            return $redirect = 'home';
        }

        return $resetForm->createView();
    }
}