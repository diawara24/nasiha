<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * Return all anonce per page
     * @return  void
    */    
    public function getPaginatedArticles($page, $limit){
        $query = $this->createQueryBuilder('a')
            ->orderBy('a.id','DESC')
            ->setFirstResult(($page * $limit)-$limit)
            ->setMaxResults($limit)
        ;
        return $query->getQuery()->getResult();

    }

     /**
     * Return total videos
     * @return  void
    */ 
    public function getTotalArticles(){
        $query = $this->createQueryBuilder('a')
            ->select('COUNT(a)')
        ;
        return $query->getQuery()->getSingleScalarResult();
    }

    /**
     * Return article recent
     * @return  void
    */ 
    public function getArticleRecent(){
        $query = $this->createQueryBuilder('a')
            ->orderBy('a.id','DESC')
        ;
        
        return $query->getQuery()->getResult();
    }

}
