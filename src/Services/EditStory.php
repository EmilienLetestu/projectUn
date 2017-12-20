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

class EditStory
{
    private $formFactory;
    private $doctrine;


    /**
     * EditStory constructor.
     * @param FormFactory $formFactory
     * @param EntityManager $doctrine
     */
    public function __construct(
        FormFactory   $formFactory,
        EntityManager $doctrine
    )
    {
        $this->formFactory  = $formFactory;
        $this->doctrine     = $doctrine;
    }

    public function processAndEdit(Request $request)
    {
        $story = new Story();

        $form = $this->formFactory->create(EditStoryType::class, $story);

        return $form->createView();
    }

}