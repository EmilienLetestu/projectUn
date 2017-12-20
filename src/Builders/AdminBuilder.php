<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 20/12/2017
 * Time: 16:50
 */

namespace App\Builders;


use App\Managers\PatronageManager;
use App\Managers\StoryManager;
use App\Managers\TopicManager;
use App\Services\AddPatronage;
use App\Services\AddStory;
use App\Services\AddTopic;
use App\Services\EditStory;
use Symfony\Component\HttpFoundation\Request;

class AdminBuilder
{
    private $addTopic;
    private $topicManager;
    private $addPatronage;
    private $patronageManager;
    private $editStory;
    private $storyManager;


    /**
     * AdminBuilder constructor.
     * @param AddTopic $addTopic
     * @param TopicManager $topicManager
     * @param AddPatronage $addPatronage
     * @param PatronageManager $patronageManager
     * @param EditStory $editStory
     * @param StoryManager $storyManager
     */
    public function __construct(
        AddTopic         $addTopic,
        TopicManager     $topicManager,
        AddPatronage     $addPatronage,
        PatronageManager $patronageManager,
        EditStory        $editStory,
        StoryManager     $storyManager
    )
    {
        $this->addTopic         = $addTopic;
        $this->topicManager     = $topicManager;
        $this->addPatronage     = $addPatronage;
        $this->patronageManager = $patronageManager;
        $this->editStory        = $editStory;
        $this->storyManager     = $storyManager;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function buildAdminTopic(Request $request)
    {
        return[
            $this->topicManager->fetchTopicForAdmin(),
            $this->addTopic->processTopic($request)
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function buildAdminPatronage(Request $request)
    {
        return[
            $this->patronageManager->fetchPatronageForAdmin(),
            $this->addPatronage->processPatronage($request)
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function buildAdminEditStory(Request $request)
    {
        return[
            $this->storyManager->fetchOneStoryForAdmin($request),
            $this->editStory->processAndEdit($request)
        ];
    }
}
