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
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StoryManager
{
    private $doctrine;
    private $session;

    /**
     * StoryManager constructor.
     * @param EntityManager $doctrine
     * @param Session $session
     */
    public function __construct(
        EntityManager $doctrine,
        Session       $session
    )
    {
        $this->doctrine = $doctrine;
        $this->session = $session;
    }

    /**
     * @return array
     */
    public function fetchForHome()
    {
        $storyList = $this->doctrine->getRepository(Story::class)
            ->findLastPublished('ASC','createdOn',6);

        return $storyList;
    }

    /**
     * @param Request $request
     * @param $limit
     * @return mixed
     */
    public function fetchForBrowser(Request $request,$limit)
    {
        //get current page number from url param
        $pageNumber = $request->attributes->get('pageNumber');

        //find where to start
        $firstR = ($pageNumber-1)*$limit;

        //fetch stories to display
        $storyList = $this->doctrine->getRepository(Story::class)
            ->findAllForBrowser($firstR,$limit);

        //calculate the total number of pages
        $totalPage = ceil(count($storyList)/$limit);

        if($pageNumber > $totalPage)
        {
            throw new NotFoundHttpException('This page doesn\'t exist yet');
        }

        return [
            $storyList,
            $pageNumber,
            $totalPage
            ]
        ;
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