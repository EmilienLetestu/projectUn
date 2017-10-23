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
use App\Entity\Url;
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
    public function fetchForHome()
    {
        $storyList = $this->doctrine->getRepository(Story::class)
            ->findLastPublished('ASC','createdOn',9);

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
        $repoStory = $this->doctrine->getRepository(Story::class);
        $story = $repoStory->findOneBy(['id'=>$id]);
        //get url repo
        $repoUrl = $this->doctrine->getRepository(Url::class);

        //return story to display and related stories
        return [
            $story,
            $repoStory->findAllWithSameTopic($story->getTopic()->getId(), $id),
            $repoStory->findAllWithSameCountry($story->getCountry(), $id),
            $repoStory->findAllWithSameYear($story->getYear(), $id),
            $repoStory->findAllWithSamePatronage($story->getPatronage()->getId(),$id),
            $repoUrl->findBy(['story'=>$id])
        ];
    }

}