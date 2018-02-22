<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 03/01/2018
 * Time: 16:06
 */

namespace App\Action\Admin;


use App\Entity\Topic;
use App\Form\EditTopicType;
use App\Handler\Inter\EditTopicHandlerInterface;
use App\Responder\Admin\AdminTopicResponder;
use App\Services\EditTopic;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AdminTopicAction
{
    private $doctrine;
    private $urlGenerator;
    private $editTopicHandler;
    private $formFactory;

    /**
     * AdminTopicAction constructor.
     * @param EntityManagerInterface $doctrine
     * @param UrlGeneratorInterface $urlGenerator
     * @param EditTopicHandlerInterface $editTopicHandler
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(
        EntityManagerInterface    $doctrine,
        UrlGeneratorInterface     $urlGenerator,
        EditTopicHandlerInterface $editTopicHandler,
        FormFactoryInterface      $formFactory
    )
    {
        $this->doctrine         = $doctrine;
        $this->urlGenerator     = $urlGenerator;
        $this->editTopicHandler = $editTopicHandler;
        $this->formFactory      = $formFactory;
    }

    /**
     * @param Request $request
     * @param AdminTopicResponder $responder
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request, AdminTopicResponder $responder)
    {
       $repository = $this->doctrine->getRepository(Topic::class);

       $form = $this->formFactory
                    ->create(EditTopicType::class)
                    ->handleRequest($request)
       ;
       $topic = new Topic();

       if($this->editTopicHandler->handle($form, $topic)){
           return new RedirectResponse(
               $this->urlGenerator
                   ->generate('adminTopic')
           );
       }

       return $responder(
           $repository->findAll(),
           $form->createView()
       );
    }
}
