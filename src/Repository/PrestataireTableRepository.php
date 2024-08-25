<?php

namespace App\Repository;

use App\Entity\PrestataireTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PrestataireTable>
 *
 * @method PrestataireTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method PrestataireTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method PrestataireTable[]    findAll()
 * @method PrestataireTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrestataireTableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PrestataireTable::class);
    }

    //    /**
    //     * @return PrestataireTable[] Returns an array of PrestataireTable objects
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

    //    public function findOneBySomeField($value): ?PrestataireTable
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
