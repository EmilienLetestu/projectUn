<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 12/10/17
 * Time: 09:08
 */
namespace App\Managers;

use App\Entity\Story;
use App\Entity\Url;
use App\Form\SearchType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StoryManager
{
    private $doctrine;


    /**
     * StoryManager constructor.
     * @param EntityManager $doctrine
     */
    public function __construct(EntityManager $doctrine)
    {
        $this->doctrine    = $doctrine;
    }

    public function validateStory($id)
    {
        $repository = $this->doctrine->getRepository(Story::class);
        $story = $repository->find($id);

        $story->setValidated(true);
        $this->doctrine->persist($story);
        $this->doctrine->flush();

        return 'Story has been validated and published';
    }

    /**
     * @param $id
     * @return string
     */
    public function deleteStory($id)
    {
        $repository = $this->doctrine->getRepository(Story::class);
        $story = $repository->find($id);

        $this->doctrine->remove($story);
        $this->doctrine->flush();

        return 'Story has been deleted';
    }


    /**
     * @return array
     */
    public function fetchStoryForAdmin()
    {
        $repository = $this->doctrine->getRepository(Story::class);
        return [
            $repository->findAll(),
            'STORIES'
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function fetchStoryByUser($id)
    {
        $repository = $this->doctrine->getRepository(Story::class);

        return [
            $story = $repository->findBy(['user' => $id]),
            $story[0]->getUser()->getFullname().' STORIES'
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function fetchStoryByWorldArea($id)
    {
        $repository = $this->doctrine->getRepository(Story::class);

        $worldArea = [
            '1' =>  'Africa',
            '2' =>  'Asia',
            '3' =>  'Europe',
            '4' =>  'North America',
            '5' =>  'South America',
            '6' =>  'Oceania'
        ];

        return [
            $story = $repository->findBy(['worldArea' => $id]),
           'STORIES SETS IN '.$worldArea[$story[0]->getWorldArea()]
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function fetchStoryByCountry($id)
    {
        $repository = $this->doctrine->getRepository(Story::class);

        return [
            $story = $repository->findBy(['country' => $id]),
            $story[0]->getCountry().' STORIES'
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function fetchStoryByPatronage($id)
    {
        $repository = $this->doctrine->getRepository(Story::class);

        return [
            $story = $repository->findBy(['patronage' => $id]),
            $story[0]->getPatronage()->getOrganization().' STORIES'
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function fetchStoryByTopic($id)
    {
        $repository = $this->doctrine->getRepository(Story::class);

        return [
            $story = $repository->findBy(['topic' => $id]),
            $story[0]->getTopic()->getType().' STORIES'
        ];
    }

}

