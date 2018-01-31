<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 03/01/2018
 * Time: 11:05
 */

namespace App\Action\Admin;


use App\Entity\Story;
use App\Responder\Admin\AdminByStoryResponder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class AdminByStoryAction
{
    /**
     * @var EntityManager
     */
    private $doctrine;

    /**
     * AdminByStoryAction constructor.
     * @param EntityManagerInterface $doctrine
     */
    public function __construct(EntityManagerInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param Request $request
     * @param AdminByStoryResponder $responder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(Request $request, AdminByStoryResponder $responder)
    {
        $repository = $this->doctrine->getRepository(Story::class);

        return
            $responder(
                $repository->findStory(
                $request->attributes->get('id')
            )
        );
    }
}
