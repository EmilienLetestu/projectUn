<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 03/01/2018
 * Time: 12:38
 */

namespace App\Action\Admin;


use App\Entity\Story;
use App\Form\EditStoryType;
use App\Handler\Inter\EditStoryHandlerInterface;
use App\Responder\Admin\AdminEditStoryResponder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AdminEditStoryAction
{
    private $doctrine;
    private $formFactory;
    private $session;
    private $urlGenerator;
    private $editStoryHandler;

    /**
     * AdminEditStoryAction constructor.
     * @param EntityManagerInterface $doctrine
     * @param FormFactoryInterface $formFactory
     * @param SessionInterface $session
     * @param UrlGeneratorInterface $urlGenerator
     * @param EditStoryHandlerInterface $editStoryHandler
     */
    public function __construct(
        EntityManagerInterface $doctrine,
        FormFactoryInterface   $formFactory,
        SessionInterface       $session,
        UrlGeneratorInterface  $urlGenerator,
        EditStoryHandlerInterface $editStoryHandler
    )
    {
        $this->doctrine     = $doctrine;
        $this->formFactory  = $formFactory;
        $this->session      = $session;
        $this->urlGenerator = $urlGenerator;
        $this->editStoryHandler = $editStoryHandler;
    }

    /**
     * @param Request $request
     * @param AdminEditStoryResponder $responder
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request, AdminEditStoryResponder $responder)
    {
        $id = $request->attributes->get('id');
        $story = $this->doctrine
                      ->getRepository(Story::class)
                      ->findOneBy(['id' => $id])
        ;

        $form = $this->formFactory
                     ->create(EditStoryType::class, $story)
                     ->handleRequest($request)
        ;

        if($this->editStoryHandler->handle($form, $story)) {

            $this->doctrine->flush();
            $this->session
                ->getFlashBag()
                ->add('success','Story has been updated')
            ;

            return new RedirectResponse(
                $this->urlGenerator
                     ->generate('adminByStory',['id'=>$id])
            );
        }

        return $responder($story, $form->createView());
    }
}
