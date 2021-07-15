<?php

namespace App\Repository;
use App\Entity\Video;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Video|null find($id, $lockMode = null, $lockVersion = null)
 * @method Video|null findOneBy(array $criteria, array $orderBy = null)
 * @method Video[]    findAll()
 * @method Video[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Video::class);
    }

    // /**
    //  * @return Video[] Returns an array of Video objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Video
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    /**
     * Return all video per page
     * @return  void
    */    
    public function getPaginatedVideos($page, $limit){
        $query = $this->createQueryBuilder('v')
            ->orderBy('v.id','DESC')
            ->setFirstResult(($page * $limit)-$limit)
            ->setMaxResults($limit)
        ;
        return $query->getQuery()->getResult();

    }

     /**
     * Return total videos
     * @return  void
    */ 
    public function getTotalVideos(){
        $query = $this->createQueryBuilder('v')
            ->select('COUNT(v)')
        ;
        return $query->getQuery()->getSingleScalarResult();
    }

    /**
     * Return article recent
     * @return  void
    */ 
    public function getVideoRecent(){
        $query = $this->createQueryBuilder('v')
            ->orderBy('v.id','DESC')
        ;
        
        return $query->getQuery()->getResult();
    }

    
}
