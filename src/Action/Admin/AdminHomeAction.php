<?php

/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 03/01/2018
 * Time: 09:28
 */

namespace App\Action\Admin;

use App\Entity\Story;
use App\Entity\User;
use App\Form\AdministratorCredentialType;
use App\Handler\Inter\AdministratorCredentialHandlerInterface;
use App\Responder\Admin\AdminHomeResponder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AdminHomeAction
{

    private $doctrine;
    private $formFactory;
    private $token;
    private $credentialHandler;
    private $session;

    /**
     * AdminHomeAction constructor.
     * @param EntityManagerInterface $doctrine
     * @param FormFactoryInterface $formFactory
     * @param TokenStorageInterface $token
     * @param AdministratorCredentialHandlerInterface $credentialHandler
     * @param SessionInterface $session
     */
    public function __construct(
        EntityManagerInterface                  $doctrine,
        FormFactoryInterface                    $formFactory,
        TokenStorageInterface                   $token,
        AdministratorCredentialHandlerInterface $credentialHandler,
        SessionInterface                        $session
    )
    {
        $this->doctrine          = $doctrine;
        $this->formFactory       = $formFactory;
        $this->token             = $token;
        $this->credentialHandler = $credentialHandler;
        $this->session           = $session;
    }

    /**
     * @param AdminHomeResponder $responder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request, AdminHomeResponder $responder)
    {
        $repoUser = $this->doctrine->getRepository(User::class);
        $repoStory = $this->doctrine->getRepository(Story::class);

        $form = $this->formFactory
                     ->create(AdministratorCredentialType::class)
                     ->handleRequest($request)
        ;

        $id = $this->token->getToken()->getUser()->getId();
        $user = $repoUser->findOneBy(['id'=>$id]);

        if($this->credentialHandler->handle($form,$user)) {

            $this->doctrine->flush();

            return new RedirectResponse('/admin');
        }

        return $responder(
            count($repoUser->countAll('EDIT')),
            count($repoUser->countAll('USER')),
            count($repoUser->countAllUnactivated()),
            count($repoStory->findAll()),
            $repoStory->countStories(),
            count($repoUser->findAllEditRequest()),
            $form->createView()
        );
    }
}
