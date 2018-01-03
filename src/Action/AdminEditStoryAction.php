<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 03/01/2018
 * Time: 12:38
 */

namespace App\Action;


use App\Entity\Story;
use App\Form\EditStoryType;
use App\Responder\AdminEditStoryResponder;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

final class AdminEditStoryAction
{
    private $doctrine;
    private $formFactory;
    private $session;

    /**
     * AdminEditStoryAction constructor.
     * @param EntityManager $doctrine
     * @param FormFactoryInterface $formFactory
     * @param Session $session
     */
    public function __construct(
        EntityManager        $doctrine,
        FormFactoryInterface $formFactory,
        Session              $session
    )
    {
        $this->doctrine     = $doctrine;
        $this->formFactory  = $formFactory;
        $this->session      = $session;
    }

    /**
     * @param Request $request
     * @param AdminEditStoryResponder $responder
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request, AdminEditStoryResponder $responder)
    {
        $repository = $this->doctrine->getRepository(Story::class);
        $story = $repository->findOneBy([
            'id' => $request->attributes->get('id')
        ]);

        $form = $this->formFactory
                     ->create(EditStoryType::class, $story)
                     ->handleRequest($request)
        ;

        if($form->isSubmitted() && $form->isValid()) {

            $story->setTitle(
                $form->get('title')->getData()
            );
            $story->setAbstract(
                $form->get('abstract')->getData()
            );
            $story->setPlot(
                $form->get('plot')->getData()
            );

            $this->doctrine->flush();

            $this->session
                 ->getFlashBag()
                 ->add('success','Story has been updated')
            ;
            return new RedirectResponse('/admin/story');
        }

        return $responder($story, $form->createView());
    }
}