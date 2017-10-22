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
     * fetch all stories sets in one given country but ignore one with specific id
     * will be used to create links
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

    /**
     * fetch all stories starting in one given year but ignore one with specific id
     * will be used to create links
     * @param $year
     * @param $id
     * @return array
     */
    public function findAllWithSameYear($year, $id)
    {
        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder
            ->where($queryBuilder->expr()->notIn('s.id',$id))
            ->andWhere('s.year = :year')
            ->setParameter('year',$year);

        return $queryBuilder->getQuery()->getResult();

    }

    /**
     * fetch all stories sharing one given patronage but ignore one with specific id
     * will be used to create links
     * @param $patronageId
     * @param $id
     * @return array
     */
    public function findAllWithSamePatronage($patronageId,$id)
    {
        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder
            ->where($queryBuilder->expr()->notIn('s.id',$id))
            ->andWhere('s.patronage = :id')
            ->SetParameter('id',$patronageId);
        return $queryBuilder->getQuery()->getResult();
    }
}