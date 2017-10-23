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
use App\Entity\Url;
use App\Entity\User;
use App\Form\StoryType;
use App\Form\TryType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;


class AddStory
{
    private $formFactory;
    private $doctrine;
    private $session;
    private $requestStack;
    private $token;

    public function __construct(
        FormFactory   $formFactory,
        EntityManager $doctrine,
        Session       $session,
        RequestStack  $requestStack,
        TokenStorage  $token
    )
    {
        $this->formFactory  = $formFactory;
        $this->doctrine     = $doctrine;
        $this->session      = $session;
        $this->requestStack = $requestStack;
        $this->token        = $token;
    }



    public function processAndAdd(Request $request)
    {
        $story = new Story();


        $form = $this->formFactory->create(StoryType::class, $story);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            //generate date
            $story->setCreatedOn($format='Y-m-d');
            //prepare repo
            $this->doctrine->getRepository(Story::class);

            //get user id and link user to story
            $user = $this->token->getToken()->getUser();
            $user->addStory($story);
            $story->setUser($user);

            //check if url need to be persist
            $urls = $form->get('urls')->getData();
            $href = array_filter($urls);
            if(!empty($href))
            {
                $this->processWithUrl($form,$story,$href);
            }
            //persist
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

    public function processWithUrl($form,$story,$href)
    {
        foreach ($href as $key=>$value)
        {
            $url = new Url();
            $url->setHref($value);
            $url->setAlt($value);
            $story->addUrl($url);
            $this->doctrine->persist($url);
            $this->doctrine->persist($story);
            $this->doctrine->flush();
        }
        return $form->createView();
    }
}