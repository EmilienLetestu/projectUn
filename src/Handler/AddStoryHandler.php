<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 07/01/2018
 * Time: 20:19
 */

namespace App\Handler;


use App\Entity\Story;
use App\Entity\Url;
use App\Handler\Inter\AddStoryHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AddStoryHandler implements AddStoryHandlerInterface
{
    private $doctrine;
    private $token;

    /**
     * AddStoryHandler constructor.
     * @param EntityManagerInterface $doctrine
     * @param TokenStorageInterface $token
     */
    public function __construct(
        EntityManagerInterface $doctrine,
        TokenStorageInterface  $token
    )
    {
        $this->doctrine = $doctrine;
        $this->token    = $token;
    }

    /**
     * @param FormInterface $form
     * @param Story $story
     * @return bool
     */
    public function handle(FormInterface $form, Story $story) : bool
    {
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

            return true;
        }

        return false;
    }
}