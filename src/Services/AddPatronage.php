<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 20/12/2017
 * Time: 17:20
 */

namespace App\Services;


use App\Entity\Patronage;
use App\Form\NewPatronageType;
use App\Managers\PatronageManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

class AddPatronage
{
    private $formFactory;
    private $patronageManager;

    /**
     * AddPatronage constructor.
     * @param FormFactory $formFactory
     * @param PatronageManager $patronageManager
     */
    public function __construct(
        FormFactory      $formFactory,
        PatronageManager $patronageManager
    )
    {
        $this->formFactory      = $formFactory;
        $this->patronageManager = $patronageManager;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\Form\FormView
     */
    public function processPatronage(Request $request)
    {
        $patronage = new Patronage();
        $form = $this->formFactory->create(NewPatronageType::class, $patronage);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->patronageManager->createTopic($form);
            return $form->createView();
        }

        return $form->createView();
    }


}