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
use App\Responder\Admin\AdminHomeResponder;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

final class AdminHomeAction
{

    private $doctrine;
    private $formFactory;
    private $token;

    /**
     * AdminHomeAction constructor.
     * @param EntityManager $doctrine
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(
        EntityManager        $doctrine,
        FormFactoryInterface $formFactory,
        TokenStorage         $token
    )
    {
        $this->doctrine    = $doctrine;
        $this->formFactory = $formFactory;
        $this->token       = $token;
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

        if($form->isSubmitted() && $form->isValid())
        {
            $id = $this->token->getToken()->getUser()->getId();
            $user = $repoUser->findOneBy(['id'=>$id]);

            $form->get('email')->getData() !== null ?
                $user->setEmail($form->get('email')->getData()) :
                null
            ;
            $user->setPswd($form->get('pswd')->getData());

            $this->doctrine->persist($user);
            $this->doctrine->flush();

            return new RedirectResponse('/admin');
        }

        return $responder(
            count($repoUser->countAll('EDIT')),
            count($repoUser->countAll('USER')),
            count($repoUser->countAllUnactivated()),
            count($repoStory->findAll()),
            $repoStory->countStories(),
            $form->createView()
        );
    }
}