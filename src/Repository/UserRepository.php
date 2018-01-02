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
            ->andWhere('u.registeredOn <= :date')
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
     * @param $nDaysAgo
     * @return array
     */
    public function findDeletableAccount($nDaysAgo)
    {
        $queryBuilder = $this->createQueryBuilder('u');
        $this->whereActivated($queryBuilder, false);
        $this->whereCreatedOn($queryBuilder,$nDaysAgo);

        return $queryBuilder
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return array
     */
    public function countAllUnactivated()
    {
        $queryBuilder = $this->createQueryBuilder('u');
        $this->whereActivated($queryBuilder, false);

        return $queryBuilder
            ->getQuery()
            ->getScalarResult()
        ;
    }

    /**
     * @param $role
     * @return array
     */
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