<?php

namespace App\Repository;

use App\Entity\OperationTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OperationTable>
 *
 * @method OperationTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method OperationTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method OperationTable[]    findAll()
 * @method OperationTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OperationTableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OperationTable::class);
    }

    //    /**
    //     * @return OperationTable[] Returns an array of OperationTable objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('o.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?OperationTable
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
