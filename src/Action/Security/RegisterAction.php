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
use App\Handler\Inter\RegisterHandlerInterface;
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
    private $registerHandler;

    /**
     * RegisterAction constructor.
     * @param FormFactoryInterface $formFactory
     * @param EntityManagerInterface $doctrine
     * @param \Swift_Mailer $swift
     * @param RegisterHandlerInterface $registerHandler
     */
    public function __construct(
        FormFactoryInterface     $formFactory,
        EntityManagerInterface   $doctrine,
        \Swift_Mailer            $swift,
        RegisterHandlerInterface $registerHandler
    )
    {
        $this->formFactory     = $formFactory;
        $this->doctrine        = $doctrine;
        $this->swift           = $swift;
        $this->registerHandler = $registerHandler;
    }

    public function __invoke(Request $request, RegisterResponder $responder)
    {
        $user = new User();

        $form = $this->formFactory
                     ->create(RegisterType::class, $user)
                     ->handleRequest($request)
        ;

        $handler = $this->registerHandler->handle($form, $user);

        if($handler)
        {
            //save
            $this->doctrine->persist($user);
            $this->doctrine->flush();

            //send validation email
            $this->swift->send($handler);

            return new RedirectResponse('/');
        }

        return $responder($form->createView());
    }


}