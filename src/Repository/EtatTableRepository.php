<?php

namespace App\Repository;

use App\Entity\EtatTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EtatTable>
 *
 * @method EtatTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method EtatTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method EtatTable[]    findAll()
 * @method EtatTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtatTableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EtatTable::class);
    }

    //    /**
    //     * @return EtatTable[] Returns an array of EtatTable objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?EtatTable
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
