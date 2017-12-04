<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 04/12/2017
 * Time: 15:53
 */

namespace App\Builders;


use App\Managers\StoryManager;
use Symfony\Component\HttpFoundation\Request;

class BrowserBuilder
{
    private $storyManager;

    /**
     * BrowserBuilder constructor.
     * @param StoryManager $storyManager
     */
    public function __construct(StoryManager $storyManager)
    {
        $this->storyManager = $storyManager;
    }


    /**
     * @param Request $request
     * @param $limit
     * @return array|mixed
     */
    public function buildBrowser(Request $request,$limit)
    {

      return $request->attributes->get('country') === null ?
          $this->storyManager->fetchForBrowser($request,$limit) :
          $this->storyManager->fetchWithFilter($request,$limit)
       ;

    }

}