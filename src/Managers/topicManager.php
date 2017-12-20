<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 20/12/2017
 * Time: 11:27
 */

namespace App\Managers;


use App\Entity\Topic;
use Doctrine\ORM\EntityManager;

class topicManager
{
    private $doctrine;

    /**
     * topicManager constructor.
     * @param EntityManager $doctrine
     */
    public function __construct(EntityManager $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @return array
     */
    public function fetchTopicForAdmin()
    {
        $repository = $this->doctrine->getRepository(Topic::class);

        return $repository->findAll();
    }


}