<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 04/01/2018
 * Time: 14:08
 */

namespace App\Action;


use App\Entity\User;
use App\Responder\ActivateResponder;
use App\Services\Mail;
use App\Services\Tools;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class ActivateAction
{
    private $doctrine;
    private $session;
    private $mailService;
    private $tools;
    private $swift;

    /**
     * ActivateAction constructor.
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
     * @param ActivateResponder $responder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function __invoke(Request $request, ActivateResponder $responder)
    {
        //data to check from url
        $email = $request->attributes->get('email');
        $token = $request->attributes->get('token');
        $date = $request->attributes->get('expireOn');

        $repository = $this->doctrine->getRepository(User::class);
        $user = $repository->findOneBy([
            'email' => $email,
            'confirmationToken' => $token
        ]);

        $stillValid = $this->tools->isLinkStillValid($date);

        if ($stillValid === false) {
            //send another activation email
            $message = $this->mailService->validationMail(
                $user->getName(),
                $user->getSurname(),
                $user->getConfirmationToken(),
                $user->getEmail(),
                "activation@climateStories.com"
            );

            $this->swift->send($message);
            $this->session
                ->getFlashBag()
                ->add('denied', 'Expired link, a new one has been sent to you')
            ;
            return $responder('/');
        }

        if (!$user) {
            $this->session
                ->getFlashBag()
                ->add('error', 'Unknown user')
            ;
            return $responder('/');
        }

        $user->setActivated(true);
        $this->doctrine->flush();

        $this->session
            ->getFlashBag()
            ->add('success', 'Your account has been activated !')
        ;

        return $responder('/login');
    }
}
