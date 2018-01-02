<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 02/01/2018
 * Time: 15:22
 */

namespace App\Services;


use App\Entity\Story;
use App\Entity\User;
use Doctrine\ORM\EntityManager;

class AdminStatistics
{
    private $doctrine;

    /**
     * AdminStatistics constructor.
     * @param EntityManager $doctrine
     */
    public function __construct(EntityManager $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @return array
     */
    public function adminHomeStats()
    {
        $repoUser = $this->doctrine->getRepository(User::class);
        $repoStory = $this->doctrine->getRepository(Story::class);


        return [
            count($repoUser->countAll('EDIT')),
            count($repoUser->countAll('USER')),
            count($repoUser->countAllUnactivated()),
            count($repoStory->findAll()),
            $repoStory->countStories()
        ];
    }
}