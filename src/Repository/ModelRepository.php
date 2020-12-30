<?php

namespace App\Repository;

use App\Entity\Model;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Model|null find($id, $lockMode = null, $lockVersion = null)
 * @method Model|null findOneBy(array $criteria, array $orderBy = null)
 * @method Model[]    findAll()
 * @method Model[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Model::class);
    }

    public function findByName($query)
    {
        $qb = $this->createQueryBuilder('m')
            ->where("m.name LIKE :query")
            ->setParameter('query', '%' . $query . '%');
        return $qb->getQuery()->getResult();

    }

    public function findByFilter(array $filters)
    {
        $qb = $this->createQueryBuilder('m');
        // Création d'un tableau pour éviter les doublons de jointures
        $aliasList = [];

        $parameters = [];
        $parameterIndex = 0;

        //
        foreach ($filters as $filter) {
            $filterType = strtolower($filter['filter']->getFormType());
            $filterCondition = $filter['condition']->getOperator();
            $aliasName = substr($filterType, 0, 2);
            $query = $filter['entity_option'];
            $colName = 'id';
            if ($filterType == 'name' || $filterType == 'price') {
                $query = $filter['text_option'];
                $colName = $filterType;
                $aliasName = 'm';

                if ($filterType == 'name') {
                    $filterCondition === '=' ? $filterCondition = 'LIKE' : $filterCondition = 'NOT LIKE';
                    $query = '%' . $query . '%';
                }
            }
            $alreadyJoin = (array_search($aliasName, $aliasList) !== false);
            if (!$alreadyJoin) {
                if ($aliasName != 'm') {
                    if ($aliasName == 'er' || $aliasName == 'se') {

                        if (array_search('un', $aliasList) === false) {
                            $qb->join('m.unit', 'un');
                            $aliasList[] = 'un';
                        }
                        if (array_search('se', $aliasList) === false) {
                            $qb->join('un.serie', 'se');
                            if ($aliasName == 'er') $aliasList[] = 'se';
                        }
                        if ($aliasName == 'er') $qb->join('se.era', 'er');
                    } else {
                        $qb->join('m.' . $filterType, $aliasName);
                    }
                }
                $aliasList[] = $aliasName;
            }
            $whereQuery = $aliasName . '.' . $colName . ' ' . $filterCondition . ' ' . ':query' . $parameterIndex;
            if ($alreadyJoin && ($filterCondition === '=' || $filterCondition === 'LIKE')) {
//                dump('or');
                $qb->orWhere($whereQuery);
            } else {
//                dump('and');
                $qb->andWhere($whereQuery);
            }
            $parameters['query' . $parameterIndex++] = $query;

        }
        $qb->setParameters($parameters);
        return $qb->getQuery()->getResult();
    }
    // /**
    //  * @return Model[] Returns an array of Model objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Model
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
