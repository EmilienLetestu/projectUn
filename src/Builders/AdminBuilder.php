<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 20/12/2017
 * Time: 16:50
 */

namespace App\Builders;


use App\Managers\TopicManager;
use App\Services\AddTopic;
use Symfony\Component\HttpFoundation\Request;

class AdminBuilder
{
    private $addTopic;
    private $topicManager;

    /**
     * AdminBuilder constructor.
     * @param AddTopic $addTopic
     * @param TopicManager $topicManager
     */
    public function __construct(
        AddTopic     $addTopic,
        TopicManager $topicManager
    )
    {
        $this->addTopic     = $addTopic;
        $this->topicManager = $topicManager;
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
}