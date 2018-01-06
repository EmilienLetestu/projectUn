<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 03/01/2018
 * Time: 16:06
 */

namespace App\Action\Admin;


use App\Entity\Topic;
use App\Responder\Admin\AdminTopicResponder;
use App\Services\EditTopic;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AdminTopicAction
{
    private $doctrine;
    private $editTopic;
    private $session;
    private $urlGenerator;

    /**
     * AdminTopicAction constructor.
     * @param EntityManagerInterface $doctrine
     * @param EditTopic $editTopic
     * @param SessionInterface $session
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        EntityManagerInterface $doctrine,
        EditTopic              $editTopic,
        SessionInterface       $session,
        UrlGeneratorInterface  $urlGenerator
    )
    {
        $this->doctrine    = $doctrine;
        $this->editTopic   = $editTopic;
        $this->session     = $session;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param Request $request
     * @param AdminTopicResponder $responder
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request, AdminTopicResponder $responder)
    {
       $repository = $this->doctrine->getRepository(Topic::class);

       $form = $this->editTopic->processTopic($request);

       if($this->session->get('added')) {
           $this->session->remove('added');
           return new RedirectResponse(
               $this->urlGenerator
                    ->generate('adminTopic')
           );
       }

       return $responder($repository->findAll(),$form);
    }
}