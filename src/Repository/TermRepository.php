<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 31/01/2018
 * Time: 16:09
 */

namespace App\Repository;


use Doctrine\ORM\EntityRepository;

class TermRepository extends  EntityRepository
{
    /**
     * @param $status
     * @return mixed
     */
    public function findAllWithStatus($status)
    {
        $queryBuilder = $this->createQueryBuilder('t');
        $queryBuilder
            ->where('t.status = :status')
            ->setParameter('status', $status)
        ;
        return $queryBuilder
            ->getQuery()
            ->getResult()
       ;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findWithId($id)
    {
        $queryBuilder = $this->createQueryBuilder('t');
        $queryBuilder
            ->where('t.id = :id')
            ->setParameter('id', $id)
        ;
        return $queryBuilder
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}