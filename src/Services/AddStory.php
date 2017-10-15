<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 11/10/17
 * Time: 16:28
 */

namespace App\Services;

use App\Entity\Patronage;
use App\Entity\Story;
use App\Form\StoryType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;


class AddStory
{
    private $formFactory;
    private $doctrine;
    private $session;
    private $requestStack;

    public function __construct(
        FormFactory   $formFactory,
        EntityManager $doctrine,
        Session       $session,
        RequestStack  $requestStack
    )
    {
        $this->formFactory  = $formFactory;
        $this->doctrine     = $doctrine;
        $this->session      = $session;
        $this->requestStack = $requestStack;
    }

    public function processAndAdd(Request $request)
    {
        $story = new Story();
        $patronage = new Patronage();

        $form = $this->formFactory->create(StoryType::class, $story);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            //generate date
            $story->setCreatedOn($format='Y-m-d');
            //prepare repo
            $this->doctrine->getRepository(Story::class);

            //get submitted data from child form for "patronage"
            $patronageData = $form->get("patronage")->getData();
            $patronage->setOrganization($patronageData['organization']);
            $patronage->setIdentity('identity');

            //handle entity relation between patronage and story
            $story->setPatronage($patronage);
            $patronage->addStory($story);

            //persist
            $this->doctrine->persist($patronage);
            $this->doctrine->persist($story);
            $this->doctrine->flush();

            $this->session->getFlashBag()->add(
                'success',
                'Your story was successfully added to our database')
            ;

            return $form->createView();
        }

        return $form->createView();
    }
}