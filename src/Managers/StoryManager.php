<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 12/10/17
 * Time: 09:08
 */
namespace App\Managers;

use App\Entity\Story;
use App\Entity\Topic;
use App\Entity\Url;
use App\Form\SearchType;
use App\Services\Tools;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StoryManager
{
    private $doctrine;
    private $formFactory;
    private $router;

    /**
     * StoryManager constructor.
     * @param EntityManager $doctrine
     * @param FormFactory $formFactory
     */
    public function __construct(
        EntityManager $doctrine,
        FormFactory   $formFactory,
        Router        $router

    )
    {
        $this->doctrine    = $doctrine;
        $this->formFactory = $formFactory;
        $this->router      = $router;
    }

    /**
     * @return array
     */
    public function fetchForHome()
    {
        $repository = $this->doctrine->getRepository(Story::class);
        $repository-> countStories();

        return [
            $repository ->findLastPublished('DESC','createdOn',6),
            $repository-> countStories()
        ];
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
            $totalPage,
            $this->createSearchForm(),
            'Our climate stories safe  holds '.count($storyList),
            null,
            null,
            null
        ];
    }

    public function fetchWithFilter(Request $request, $limit)
    {

        //get current page number from url param
        $pageNumber = $request->attributes->get('pageNumber');
        $country    = $request->attributes->get('country');
        $topic      = $request->attributes->get('topic');
        $patronage  = $request->attributes->get('patronage');

        //find where to start
        $firstR = ($pageNumber-1)*$limit;

        //fetch filtered story
        $storyList = $this->doctrine->getRepository(Story::class)
            ->findAllForBrowser($firstR,$limit,$country,$topic,$patronage);

        return [
            $storyList,
            $pageNumber,
            $totalPage = ceil(count($storyList)/$limit),
            $this->createSearchForm(),
            'We found '.count($storyList),
            $country,
            $topic,
            $patronage
        ];
    }

    public function processFilterForm(Request $request, $limit)
    {
        $filter = $this->formFactory->create(SearchType::class);
        $filter->handleRequest($request);

        if($filter->isSubmitted() && $filter->isValid())
        {
            $country = $filter->get('country')->getData();
            $topic   = $filter->get('topic')->getData();
            $patronage = $filter->get('patronage')->getData();


            return [
                $country === null ? 'all' : $country,
                $topic === null ? 'all':$topic->getId(),
                $patronage === null ? 'all':$patronage->getId()

            ];

        }
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
            $repoUrl->findBy(['story'=>$id]),
            $repoStory->findNext($id),
            $repoStory->findPrevious($id)
        ];
    }

    /**
     * @return \Symfony\Component\Form\FormView
     */
    public function createSearchForm()
    {
        $filter = $this->formFactory->create(SearchType::class);
        return  $filter->createView();
    }

}
