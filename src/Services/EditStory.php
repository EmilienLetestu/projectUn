<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 20/12/2017
 * Time: 23:29
 */

namespace App\Services;


use App\Entity\Story;
use App\Form\EditStoryType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class EditStory
{
    private $formFactory;
    private $doctrine;
    private $session;


    /**
     * EditStory constructor.
     * @param FormFactory $formFactory
     * @param EntityManager $doctrine
     * @param Session $session
     */
    public function __construct(
        FormFactory   $formFactory,
        EntityManager $doctrine,
        Session       $session
    )
    {
        $this->formFactory  = $formFactory;
        $this->doctrine     = $doctrine;
        $this->session      = $session;
    }

    public function processAndEdit(Request $request, $storyToEdit)
    {
        $story = new Story();

        $form = $this->formFactory->create(EditStoryType::class, $story);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {

            $storyToEdit->setTitle(
                $form->get('title')->getData()
            );
            $storyToEdit->setAbstract(
                $form->get('abstract')->getData()
            );
            $storyToEdit->setPlot(
                $form->get('plot')->getData()
            );

            $this->doctrine->flush();

            $this->session->getFlashBag()
                ->add('success',
                    'Story has been updated'
                )
            ;

            return $form->createView();
        }

        return $form->createView();
    }

}