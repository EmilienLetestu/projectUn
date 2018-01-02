<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 02/01/2018
 * Time: 14:37
 */

namespace App\Repository;


use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    /**
     * @param QueryBuilder $queryBuilder
     * @param $activated
     */
    public function whereActivated(QueryBuilder $queryBuilder, $activated)
    {
        $queryBuilder
            ->andWhere('u.activated = :activated')
            ->setParameter('activated',$activated)
        ;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param $targetedDate
     */
    public function whereCreatedOn(QueryBuilder $queryBuilder, $targetedDate)
    {
        $date = date('Y-m-d', strtotime($targetedDate));
        $queryBuilder
            ->andWhere('u.createdOn <= :date')
            ->setParameter('date', new \DateTime($date))
        ;
    }

    public function whereRole(QueryBuilder $queryBuilder, $role)
    {
        $queryBuilder
            ->andWhere('u.role = :role')
            ->setParameter('role', $role)
        ;
    }

    /**
     * @param $nMonthAgo
     * @return array
     */
    public function findDeletableAccount($nMonthAgo)
    {
        $queryBuilder = $this->createQueryBuilder('u');
        $this->whereActivated($queryBuilder, false);
        $this->whereCreatedOn($queryBuilder,$nMonthAgo);

        return $queryBuilder
            ->getQuery()
            ->getResult()
        ;
    }

    public function countAll($role)
    {
        $queryBuilder = $this->createQueryBuilder('u');
        $this->whereRole($queryBuilder, $role);

        return $queryBuilder
            ->getQuery()
            ->getScalarResult()
        ;
    }

}