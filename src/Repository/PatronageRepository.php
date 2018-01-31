<?php
/**
 * Created by PhpStorm.
 * User: Emilien
 * Date: 31/01/2018
 * Time: 16:32
 */

namespace App\Repository;


use Doctrine\ORM\EntityRepository;

class PatronageRepository extends EntityRepository
{
    /**
     * @param $id
     * @return mixed
     */
    public function findPatronage($id)
    {
        $queryBuilder = $this->createQueryBuilder('p');
        $queryBuilder
            ->where('p.id = :id')
            ->setParameter('id', $id)
        ;

        return $queryBuilder
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}