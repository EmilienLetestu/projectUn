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
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StoryManager
{
    private $doctrine;
    private $session;
    private $formFactory;

    /**
     * StoryManager constructor.
     * @param EntityManager $doctrine
     * @param Session $session
     * @param FormFactory $formFactory
     */
    public function __construct(
        EntityManager $doctrine,
        Session       $session,
        FormFactory   $formFactory

    )
    {
        $this->doctrine    = $doctrine;
        $this->session     = $session;
        $this->formFactory = $formFactory;
    }

    /**
     * @return array
     */
    public function fetchForHome()
    {
        $repository = $this->doctrine->getRepository(Story::class);
            if(!$this->session->get('total'))
            {

               $total = $repository-> countStories();
               $this->session->set('total',$total[0]);

               return [
                   $repository->findLastPublished('ASC','createdOn',6),
                   $this->session->get('total')
               ];
            }
        return [
            $repository ->findLastPublished('ASC','createdOn',6),
            $this->session->get('total')
        ];
    }

    /**
     * @param Request $request
     * @param $limit
     * @return mixed
     */
    public function fetchForBrowser(Request $request,$limit)
    {
        //create search form
        $filter = $this->formFactory->create(SearchType::class);

        //get requested filters
        $filter->handleRequest($request);

        if($filter->isSubmitted() && $filter->isValid())
        {
            //get current page number from url param
            $pageNumber = $request->attributes->get('pageNumber');
            //find where to start
            $firstR = ($pageNumber-1)*$limit;
            //get all submitted data
            $country = $filter->get('country')->getData();
            $topic   = $filter->get('topic')->getData();
            $patronage = $filter->get('patronage')->getData();

            $storyList = $this->doctrine->getRepository(Story::class)
            ->findAllForBrowser($firstR,$limit,$country,$topic,$patronage);


            return [
                $storyList,
                $pageNumber,
                $totalPage = ceil(count($storyList)/$limit),
                $filter->createView(),
                $title = 'We found '.count($storyList)
            ];
        }
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
            $filter->createView(),
            $title = 'Our climate stories safe  holds '.count($storyList)
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