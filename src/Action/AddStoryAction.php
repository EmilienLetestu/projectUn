<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 04/01/2018
 * Time: 08:57
 */

namespace App\Action;


use App\Entity\Story;
use App\Form\StoryType;
use App\Handler\Inter\AddStoryHandlerInterface;
use App\Responder\AddStoryResponder;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AddStoryAction
{
    private $formFactory;
    private $session;
    private $urlGenerator;
    private $addStoryHandler;

    /**
     * AddStoryAction constructor.
     * @param FormFactoryInterface $formFactory
     * @param SessionInterface $session
     * @param UrlGeneratorInterface $urlGenerator
     * @param AddStoryHandlerInterface $addStoryHandler
     */
    public function __construct(
        FormFactoryInterface     $formFactory,
        SessionInterface         $session,
        UrlGeneratorInterface    $urlGenerator,
        AddStoryHandlerInterface $addStoryHandler

    )
    {
        $this->formFactory     = $formFactory;
        $this->session         = $session;
        $this->urlGenerator    = $urlGenerator;
        $this->addStoryHandler = $addStoryHandler;
    }

    public function __invoke(Request $request, AddStoryResponder $responder)
    {
        $story = new Story();

        $form = $this->formFactory
                     ->create(StoryType::class, $story)
                     ->handleRequest($request)
        ;

        if($this->addStoryHandler->handle($form, $story))
        {
            $this->session->getFlashBag()->add(
                'success',
                'Your story was successfully added to our database')
            ;

            return new RedirectResponse(
                $this->urlGenerator
                     ->generate('addStory')
            );
        }

        return $responder($form->createView());
    }
}
