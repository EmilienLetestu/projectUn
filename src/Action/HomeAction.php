<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 03/01/2018
 * Time: 23:43
 */

namespace App\Action;


use App\Entity\Story;
use App\Form\SearchType;
use App\Managers\NotificationManager;
use App\Responder\HomeResponder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;

class HomeAction
{
    private $doctrine;
    private $formFactory;
    private $notificationManager;

    /**
     * HomeAction constructor.
     * @param EntityManagerInterface $doctrine
     * @param FormFactoryInterface $formFactory
     * @param NotificationManager $notificationManager
     */
    public function __construct(
        EntityManagerInterface $doctrine,
        FormFactoryInterface   $formFactory,
        NotificationManager    $notificationManager
    )
    {
        $this->doctrine            = $doctrine;
        $this->formFactory         = $formFactory;
        $this->notificationManager = $notificationManager;
    }

    /**
     * @param HomeResponder $responder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(HomeResponder $responder)
    {
        $repository = $this->doctrine->getRepository(Story::class);
        $form = $this->formFactory->create(SearchType::class);

        //handle notification
        $notification = $this->notificationManager->getNotificationForUser();

        return
            $responder(
            $repository->findLastPublished('DESC','createdOn',6),
            $repository-> countStories(),
            $form->createView(),
            $notification
        );
    }
}
