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
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Session\Session;

class AddPatronage
{
    private $formFactory;
    private $doctrine;
    private $session;

    /**
     * AddPatronage constructor.
     * @param FormFactory $formFactory
     * @param EntityManager $doctrine
     * @param Session $session
     */
    public function __construct(
        FormFactory    $formFactory,
        EntityManager  $doctrine,
        Session        $session
    )
    {
        $this->formFactory = $formFactory;
        $this->doctrine    = $doctrine;
        $this->session     = $session;
    }

    /**
     * @param $request
     * @return \Symfony\Component\Form\FormView
     */
    public function processPatronage($request)
    {
        $patronage = new Patronage();
        $form = $this->formFactory->create(NewPatronageType::class, $patronage);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->doctrine->persist($patronage);
            $this->doctrine->flush();

            $this->session->set('added',1);

            return $form->createView();
        }

        return $form->createView();
    }

}