<?php

namespace App\Repository;

use App\Entity\CompteFondsDeCaissesTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompteFondsDeCaissesTable>
 *
 * @method CompteFondsDeCaissesTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompteFondsDeCaissesTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompteFondsDeCaissesTable[]    findAll()
 * @method CompteFondsDeCaissesTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompteFondsDeCaissesTableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompteFondsDeCaissesTable::class);
    }

    //    /**
    //     * @return CompteFondsDeCaissesTable[] Returns an array of CompteFondsDeCaissesTable objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?CompteFondsDeCaissesTable
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
