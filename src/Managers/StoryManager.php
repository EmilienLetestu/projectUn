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
    private $formFactory;

    /**
     * StoryManager constructor.
     * @param EntityManager $doctrine
     * @param FormFactory $formFactory
     */
    public function __construct(
        EntityManager $doctrine,
        FormFactory   $formFactory

    )
    {
        $this->doctrine    = $doctrine;
        $this->formFactory = $formFactory;

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
            null,
            null
        ];
    }

    public function fetchWithFilter(Request $request, $limit)
    {

        //get current page number from url param
        $pageNumber = $request->attributes->get('pageNumber');
        $worldArea  = $request->attributes->get('worldArea');
        $country    = $request->attributes->get('country');
        $topic      = $request->attributes->get('topic');
        $patronage  = $request->attributes->get('patronage');

        //find where to start
        $firstR = ($pageNumber-1)*$limit;

        //fetch filtered story
        $storyList = $this->doctrine->getRepository(Story::class)
            ->findAllForBrowser($firstR,$limit,$worldArea,$country,$topic,$patronage);

        return [
            $storyList,
            $pageNumber,
            $totalPage = ceil(count($storyList)/$limit),
            $this->createSearchForm(),
            'WE\'VE FOUND '.count($storyList),
            $country,
            $topic,
            $patronage,
            $worldArea
        ];
    }

    public function processFilterForm(Request $request)
    {
        $filter = $this->formFactory->create(SearchType::class);
        $filter->handleRequest($request);

        if($filter->isSubmitted() && $filter->isValid())
        {
            $country   = $filter->get('country')->getData();
            $topic     = $filter->get('topic')->getData();
            $patronage = $filter->get('patronage')->getData();
            $worldArea = $filter->get('worldArea')->getData();



            return [
                $worldArea === null ? 'all' : $worldArea,
                $country   === null ? 'all' : $country,
                $topic     === null ? 'all' : $topic->getId(),
                $patronage === null ? 'all' : $patronage->getId()
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

    /**
     * @return array
     */
    public function fetchStoryForAdmin()
    {
        $repository = $this->doctrine->getRepository(Story::class);

        return $repository->findAll();
    }

    /**
     * @param Request $request
     * @return null|object
     */
    public function fetchOneStoryForAdmin(Request $request)
    {
        $repository = $this->doctrine->getRepository(Story::class);

        return $repository->findOneBy([
            'id'=>$request->attributes->get('id')
        ]);
    }

    /**
     * @param $id
     * @return array
     */
    public function fetchStoryByUser($id)
    {
        $repository = $this->doctrine->getRepository(Story::class);

        return $repository->findBy(['user' => $id]);
    }

    /**
     * @param $id
     * @return array
     */
    public function fetchStoryByWorldArea($id)
    {
        $repository = $this->doctrine->getRepository(Story::class);

        return $repository->findBy(['worldArea' => $id]);
    }

    /**
     * @param $id
     * @return array
     */
    public function fetchStoryByCountry($id)
    {
        $repository = $this->doctrine->getRepository(Story::class);

        return $repository->findBy(['country' => $id]);
    }

    /**
     * @param $id
     * @return array
     */
    public function fetchStoryByPatronage($id)
    {
        $repository = $this->doctrine->getRepository(Story::class);

        return $repository->findBy(['patronage' => $id]);
    }

    /**
     * @param $id
     * @return array
     */
    public function fetchStoryByTopic($id)
    {
        $repository = $this->doctrine->getRepository(Story::class);

        return $repository->findBy(['topic' => $id]);
    }

}

