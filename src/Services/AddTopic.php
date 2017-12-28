<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 20/12/2017
 * Time: 16:32
 */

namespace App\Services;


use App\Entity\Topic;
use App\Form\NewTopicType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Session\Session;

class AddTopic
{
    private $formFactory;
    private $doctrine;
    private $session;

    /**
     * AddTopic constructor.
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

    /**
     * @param $request
     * @return \Symfony\Component\Form\FormView
     */
    public function processTopic($request)
    {
        $topic = new Topic();
        $form = $this->formFactory->create(NewTopicType::class, $topic);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->doctrine->persist($topic);
            $this->doctrine->flush();

            $this->session->set('added',1);

            return $form->createView();
        }

        return $form->createView();
    }
}

