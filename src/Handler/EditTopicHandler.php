<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 07/01/2018
 * Time: 15:48
 */

namespace App\Handler;


use App\Entity\Topic;
use App\Handler\Inter\EditTopicHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;

class EditTopicHandler implements EditTopicHandlerInterface
{
    private $doctrine;

    /**
     * EditTopicHandler constructor.
     * @param EntityManagerInterface $doctrine
     */
    public function __construct(EntityManagerInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param FormInterface $form
     * @param Topic $topic
     * @return bool
     */
    public function handle(FormInterface $form, Topic $topic): bool
    {
        if($form->isSubmitted() && $form->isValid())
        {
            if($form->get('topicId')->getData() !== null)
            {
                $repository = $this->doctrine->getRepository(Topic::class);
                $topic = $repository->find($form->get('topicId')->getData());
                $topic->setType($form->get('type')->getData());
            }

            $topic->setType($form->get('type')->getData());
            $this->doctrine->persist($topic);
            $this->doctrine->flush();

           return true;
        }

        return false;
    }
}
