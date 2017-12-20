<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 20/12/2017
 * Time: 16:32
 */

namespace App\Services;


use App\Entity\Topic;
use App\Form\NewTopicType;
use App\Managers\TopicManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;

class AddTopic
{
    private $formFactory;
    private $topicManager;

    /**
     * AddTopic constructor.
     * @param FormFactory $formFactory
     * @param TopicManager $topicManager
     */
    public function __construct(
        FormFactory $formFactory,
        TopicManager $topicManager
    )
    {
        $this->formFactory  = $formFactory;
        $this->topicManager = $topicManager;
    }

    public function processTopic(Request $request)
    {
        $topic = new Topic();
        $form = $this->formFactory->create(NewTopicType::class, $topic);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->topicManager->createTopic($form);
            return $form->createView();
        }

        return $form->createView();
    }
}
