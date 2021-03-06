<?php
/**
 * Created by PhpStorm.
 * User: emil
 * Date: 12/10/17
 * Time: 12:30
 */

namespace  App\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class StoryRepository extends EntityRepository
{

    /**
     * @param $topicId
     * @param $country
     * @param $year
     * @param $patronageId
     * @param $id
     * @return mixed
     */
    public function findAllRelated($topicId,$country,$year,$patronageId,$id)
    {
        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder
            ->where($queryBuilder->expr()->notIn('s.id',$id))
            ->andWhere('s.validated = 1')
            ->orHaving('s.topic = :topicId')
            ->orHaving('s.country = :country')
            ->orHaving('s.year = :year')
            ->orHaving('s.patronage = :patronageId')
            ->setParameter('topicId', $topicId)
            ->setParameter('country', $country)
            ->setParameter('year', $year)
            ->setParameter('patronageId', $patronageId);

        return $queryBuilder
               ->getQuery()
               ->getResult()
        ;
    }
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
            ->andWhere('s.validated = 1')
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
            ->andWhere('s.validated = 1')
            ->setParameter('country',$country);

        return $queryBuilder
                ->getQuery()
                ->getResult()
        ;
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
            ->andWhere('s.validated = 1')
            ->setParameter('year',$year);

        return $queryBuilder
            ->getQuery()
            ->getResult()
        ;

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
            ->andWhere('s.validated = 1')
            ->andWhere('s.patronage = :id')
            ->SetParameter('id',$patronageId);

        return $queryBuilder
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param $order
     * @param $sort
     * @param $limit
     * @return array
     */
    public function findLastPublished($order,$sort,$limit)
    {
        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder
            ->andWhere('s.validated = 1')
            ->orderBy("s.{$sort}","{$order}")
            ->setMaxResults($limit)
        ;

        return $queryBuilder
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param $firstR
     * @param $limit
     * @param null $worldArea
     * @param null $country
     * @param null $topic
     * @param null $patronage
     * @return Paginator
     */
    public function findAllForBrowser(
        $firstR,
        $limit,
        $worldArea=null,
        $country = null,
        $topic = null,
        $patronage = null
    )
    {
        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder
            ->select('s')
            ->andWhere('s.validated = 1');

            if( $worldArea !== null && $worldArea !== 'all' )
            {
                $queryBuilder
                    ->andWhere('s.worldArea = :worldArea')
                    ->setFirstResult($firstR)
                    ->setMaxResults($limit)
                    ->setParameter('worldArea',$worldArea)
                ;
            }
            if( $country !== null && $country !== 'all' )
            {
                $queryBuilder
                    ->andWhere('s.country = :country')
                    ->setFirstResult($firstR)
                    ->setMaxResults($limit)
                    ->setParameter('country',$country)
                ;
            }
            if($topic !== null && $topic !== 'all')
            {
                $queryBuilder
                    ->andWhere('s.topic = :topic')
                    ->setFirstResult($firstR)
                    ->setMaxResults($limit)
                    ->setParameter('topic',$topic);
            }
            if($patronage !== null && $patronage !== 'all')
            {
                $queryBuilder
                    ->andWhere('s.patronage = :patronage')
                    ->setFirstResult($firstR)
                    ->setMaxResults($limit)
                    ->setParameter('patronage',$patronage);
            }
            $queryBuilder
            ->setFirstResult($firstR)
            ->setMaxResults($limit)
        ;
        return new Paginator($queryBuilder);
    }

    /**
     * @return array
     */
    public function countStories()
    {
        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder
            ->select('count(s.id)')
            ->Where('s.validated = true')
        ;
        return $queryBuilder
            ->getQuery()
            ->getScalarResult()
        ;
    }


    /**
     * will be used on any given story page to create link to next story
     * @param $id
     * @return array
     */
    public function findNext($id)
    {
        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder
            ->select('s.id')
            ->andWhere('s.id > :id')
            ->setMaxResults(1)
            ->setParameter('id',$id)
        ;
        return $queryBuilder
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * will be used on any given story page to create link previous story
     * @param $id
     * @return array
     */
    public function findPrevious($id)
    {
        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder
            ->select('s.id')
            ->andWhere('s.id < :id')
            ->setMaxResults(1)
            ->orderBy('s.id','DESC')
            ->setParameter('id',$id)
        ;
        return $queryBuilder
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findStory($id)
    {
        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder
            ->where('s.id = :id')
            ->setParameter('id',$id)
        ;
        return $queryBuilder
            ->getQuery()
           ->getOneOrNullResult()
        ;
   }
}

