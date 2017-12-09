<?php

namespace App\Builders;
use App\Managers\NotificationManager;
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
    private $notificationManager;

    /**
     * HomePageBuilder constructor.
     * @param StoryManager $storyManager
     * @param NotificationManager $notificationManager
     */
    public function __construct(
        StoryManager        $storyManager,
        NotificationManager $notificationManager
    )
    {
        $this->storyManager        = $storyManager;
        $this->notificationManager = $notificationManager;
    }

    /**
     * @return array
     */
    public function buildHome()
    {
        return [
            $this->storyManager->fetchForHome(),
            $this->storyManager->createSearchForm(),
            $this->notificationManager->getNotificationForUser()
        ];
    }

}