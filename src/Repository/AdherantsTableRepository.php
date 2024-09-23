<?php

namespace App\Repository;

use App\Entity\AdherantsTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AdherantsTable>
 *
 * @method AdherantsTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdherantsTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdherantsTable[]    findAll()
 * @method AdherantsTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdherantsTableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdherantsTable::class);
    }

    //    /**
    //     * @return AdherantsTable[] Returns an array of AdherantsTable objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?AdherantsTable
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
