<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 04/01/2018
 * Time: 15:46
 */

namespace App\Action;


use App\Entity\Story;
use App\Form\SearchType;
use App\Responder\BrowseResponder;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BrowseAction
{
   private $formFactory;
   private $doctrine;

   public function __construct(
       FormFactoryInterface $formFactory,
       EntityManager        $doctrine
   )
   {
       $this->formFactory = $formFactory;
       $this->doctrine    = $doctrine;
   }

    /**
     * @param Request $request
     * @param BrowseResponder $responder
     * @return \Symfony\Component\HttpFoundation\Response
     */
   public function __invoke(Request $request,BrowseResponder $responder)
   {
       $limit = 6;
       $filter = $this->formFactory->create(SearchType::class);

       //get current page number from url param => todo param session
       $pageNumber = $request->attributes->get('pageNumber');
       $worldArea  = $request->attributes->get('worldArea');
       $country    = $request->attributes->get('country');
       $topic      = $request->attributes->get('topic');
       $patronage  = $request->attributes->get('patronage');

       //find where to start
       $firstR = ($pageNumber-1)*$limit;

       $repository = $this->doctrine->getRepository(Story::class);

       if($request->attributes->get('country') === null){

           $storyList = $repository->findAllForBrowser($firstR,$limit);

           //calculate the total number of pages
           $totalPage = ceil(count($storyList)/$limit);

           if($pageNumber > $totalPage) {
               throw new NotFoundHttpException('This page doesn\'t exist yet');
           }

           return $responder(
               $storyList,
               $pageNumber,
               $totalPage,
               $filter->createView(),
               'Our climate stories safe  holds '.count($storyList)
           );
       }

       //fetch filtered story
       $storyList = $repository->findAllForBrowser($firstR,$limit,$worldArea,$country,$topic,$patronage);

       return $responder(
           $storyList,
           $pageNumber,
           $totalPage = ceil(count($storyList)/$limit),
           $filter->createView(),
           'WE\'VE FOUND '.count($storyList),
           $country,
           $topic,
           $patronage,
           $worldArea
       );
   }
}

