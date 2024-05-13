<?php

namespace App\Repository;

use App\Entity\CompteChequesTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompteChequesTable>
 *
 * @method CompteChequesTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompteChequesTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompteChequesTable[]    findAll()
 * @method CompteChequesTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompteChequesTableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompteChequesTable::class);
    }

    //    /**
    //     * @return CompteChequesTable[] Returns an array of CompteChequesTable objects
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

    //    public function findOneBySomeField($value): ?CompteChequesTable
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
