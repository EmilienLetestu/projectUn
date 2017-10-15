<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 12/10/17
 * Time: 12:30
 */

namespace  App\Repository;


use Doctrine\ORM\EntityRepository;

class StoryRepository extends EntityRepository
{

    /**
     * fetch all stories sharing one given topic but ignore one with specific id
     * will be used to create links
     * @param $topicId
     * @param $id
     * @return array
     */
    public function findAllWithSameTopic($topicId, $id)
    {
        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder
            ->where($queryBuilder->expr()->notIn('s.id',$id))
            ->andWhere('s.topic = :id')
            ->setParameter('id',$topicId);
        return(
        $queryBuilder->getQuery()->getResult()
        );
    }

    /**
     * @param $country
     * @param $id
     * @return array
     */
    public function findAllWithSameCountry($country, $id)
    {
        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder
            ->where($queryBuilder->expr()->notIn('s.id',$id))
            ->andWhere('s.country = :country')
            ->setParameter('country',$country);

        return $queryBuilder->getQuery()->getResult();
    }

    public function findAllWithSameYear($year, $id)
    {
        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder
            ->where($queryBuilder->expr()->notIn('s.id',$id))
            ->andWhere('s.year = :year')
            ->setParameter('year',$year);

        return $queryBuilder->getQuery()->getResult();

    }

    public function finAllWithSamePatronage($organization)
    {
        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder
            ->innerJoin('s.patronage','p')
            ->addSelect('p')
        ;

        $queryBuilder->where($queryBuilder
            ->expr()
            ->in('p.organization',$organization)
        );

        return $queryBuilder->getQuery()->getResult();
    }
}