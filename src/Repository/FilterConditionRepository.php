<?php

namespace App\Repository;

use App\Entity\FilterCondition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FilterCondition|null find($id, $lockMode = null, $lockVersion = null)
 * @method FilterCondition|null findOneBy(array $criteria, array $orderBy = null)
 * @method FilterCondition[]    findAll()
 * @method FilterCondition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FilterConditionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FilterCondition::class);
    }

    // /**
    //  * @return FilterCondition[] Returns an array of FilterCondition objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FilterCondition
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
