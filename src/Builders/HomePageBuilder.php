<?php

namespace App\Builders;
use App\Managers\StoryManager;

/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 04/12/2017
 * Time: 10:21
 */
class HomePageBuilder
{

    private $storyManager;

    /**
     * HomePageBuilder constructor.
     * @param StoryManager $storyManager
     */
    public function __construct(StoryManager $storyManager)
    {
        $this->storyManager  = $storyManager;
    }

    /**
     * @return array
     */
    public function buildHome()
    {
        return [
            $this->storyManager->fetchForHome(),
            $this->storyManager->createSearchForm(),
        ];
    }

}