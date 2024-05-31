<?php

namespace App\Repository;

use App\Entity\ProjetsDevisTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProjetsDevisTable>
 *
 * @method ProjetsDevisTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjetsDevisTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjetsDevisTable[]    findAll()
 * @method ProjetsDevisTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjetsDevisTableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjetsDevisTable::class);
    }

    //    /**
    //     * @return ProjetsDevisTable[] Returns an array of ProjetsDevisTable objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ProjetsDevisTable
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
