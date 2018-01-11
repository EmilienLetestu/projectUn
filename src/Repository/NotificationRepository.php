<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 06/12/2017
 * Time: 13:12
 */

namespace App\Repository;


use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityRepository;

class NotificationRepository extends EntityRepository
{
    /**
     * @param QueryBuilder $queryBuilder
     */
    public function whereDate(QueryBuilder $queryBuilder)
    {
        $queryBuilder
            ->andWhere('notifiedOn =< :date')
            ->setParameter('date', new \DateTime(date('Y-m-d')));
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param $seen
     */
    public function whereSeen(QueryBuilder $queryBuilder, $seen)
    {
        $queryBuilder
            ->andWhere('seen = :seen')
            ->setParameter('seen', $seen);
    }


    /**
     * @param QueryBuilder $queryBuilder
     * @param $type
     */
    public function whereType(QueryBuilder $queryBuilder, $type)
    {
        $queryBuilder
            ->andWhere('type = :type')
            ->setParameter('type', $type);
    }


    /**
     * fetch all notification for a given user
     * @param $id
     * @param $seen
     * @return array
     */
    public function findNotificationForUser($id,$seen)
    {
        $queryBuilder = $this->createQueryBuilder('n');
        $queryBuilder
            ->where('n.user = :id')
            ->andWhere('n.seen = :seen')
            ->setParameter('id', $id)
            ->setParameter('seen',$seen);

        return $queryBuilder
            ->getQuery()
            ->getResult();
    }

}
