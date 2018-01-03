<?php

/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 03/01/2018
 * Time: 09:28
 */

namespace App\Action;

use App\Entity\Story;
use App\Entity\User;
use App\Responder\AdminHomeResponder;
use Doctrine\ORM\EntityManager;

final class AdminHomeAction
{
    /**
     * @var EntityManager
     */
    private $doctrine;

    /**
     * AdminHomeAction constructor.
     * @param EntityManager $doctrine
     */
    public function __construct(EntityManager $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param AdminHomeResponder $responder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke(AdminHomeResponder $responder)
    {
        $repoUser = $this->doctrine->getRepository(User::class);
        $repoStory = $this->doctrine->getRepository(Story::class);

        return $responder(
            count($repoUser->countAll('EDIT')),
            count($repoUser->countAll('USER')),
            count($repoUser->countAllUnactivated()),
            count($repoStory->findAll()),
            $repoStory->countStories()
        );
    }
}