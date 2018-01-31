<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 31/01/2018
 * Time: 16:26
 */

namespace App\Repository;


use Doctrine\ORM\EntityRepository;

class TopicRepository extends EntityRepository
{
    /**
     * @param $id
     * @return mixed
     */
    public function findTopic($id)
    {
        $queryBuilder = $this->createQueryBuilder('to');
        $queryBuilder
            ->where('to.id = :id')
            ->setParameter('id',$id)
        ;

        return $queryBuilder
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}