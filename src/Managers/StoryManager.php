<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 12/10/17
 * Time: 09:08
 */
namespace App\Managers;

use App\Entity\Patronage;
use App\Entity\Story;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

class StoryManager
{
    private $doctrine;

    /**
     * StoryManager constructor.
     * @param EntityManager $doctrine
     */
    public function __construct(EntityManager $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @return array
     */
    public function fetchForBrowsing()
    {
        $storyList = $this->doctrine->getRepository(Story::class)
            ->findAll();

        return $storyList;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function fetchForReading(Request $request)
    {
        //get story id from url
        $id = $request->attributes->get('storyId');

        //get story to display
        $repo = $this->doctrine->getRepository(Story::class);
        $story = $repo->findOneBy(['id'=>$id]);

        //return story to display and related stories
        return [
            $story,
            $repo->findAllWithSameTopic($story->getTopic()->getId(), $id),
            $repo->findAllWithSameCountry($story->getCountry(), $id),
            $repo->findAllWithSameYear($story->getYear(), $id),
            $repo->findAllWithSamePatronage($story->getPatronage()->getId(),$id)
        ];
    }

}