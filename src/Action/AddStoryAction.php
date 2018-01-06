<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 04/01/2018
 * Time: 08:57
 */

namespace App\Action;


use App\Entity\Story;
use App\Entity\Url;
use App\Form\StoryType;
use App\Responder\AddStoryResponder;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class AddStoryAction
{
    private $formFactory;
    private $doctrine;
    private $session;
    private $token;

    /**
     * AddStoryAction constructor.
     * @param FormFactoryInterface $formFactory
     * @param EntityManager $doctrine
     * @param Session $session
     * @param TokenStorage $token
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        EntityManager        $doctrine,
        Session              $session,
        TokenStorage         $token
    )
    {
        $this->formFactory  = $formFactory;
        $this->doctrine     = $doctrine;
        $this->session      = $session;
        $this->token        = $token;
    }

    public function __invoke(Request $request, AddStoryResponder $responder)
    {
        $story = new Story();

        $form = $this->formFactory
                     ->create(StoryType::class, $story)
                     ->handleRequest($request)
        ;

        if($form->isSubmitted() && $form->isValid())
        {
            //generate date
            $story->setCreatedOn('Y-m-d');
            //prepare repo
            $this->doctrine->getRepository(Story::class);

            //get user id and link user to story
            $user = $this->token->getToken()->getUser();
            $role = $user->getRole();
            $user->addStory($story);
            $story->setUser($user);

            //check role to validate story
            $validate =  $role === 'ADMIN' ? true : false;
            $story->setValidated($validate);

            //check if url need to be persist
            $urls = $form->get('urls')->getData();
            $href = array_filter($urls);
            if(!empty($href))
            {
                foreach ($href as $key=>$value)
                {
                    $url = new Url();
                    $url->setHref($value);
                    $url->setAlt($value);
                    $story->addUrl($url);
                    $this->doctrine->persist($url);
                    $this->doctrine->persist($story);
                }
                $this->doctrine->flush();
            }
            //persist
            $this->doctrine->persist($story);
            $this->doctrine->flush();
            $this->session->getFlashBag()->add(
                'success',
                'Your story was successfully added to our database')
            ;
            return new RedirectResponse('/add-story');
        }

        return $responder($form->createView());

    }
}