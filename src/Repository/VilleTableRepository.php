<?php

namespace App\Repository;

use App\Entity\VilleTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VilleTable>
 *
 * @method VilleTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method VilleTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method VilleTable[]    findAll()
 * @method VilleTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VilleTableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VilleTable::class);
    }

    //    /**
    //     * @return VilleTable[] Returns an array of VilleTable objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('v.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?VilleTable
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
