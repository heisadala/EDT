<?php

namespace App\Repository;

use App\Entity\CompteLivretTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompteLivretTable>
 *
 * @method CompteLivretTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompteLivretTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompteLivretTable[]    findAll()
 * @method CompteLivretTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompteLivretTableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompteLivretTable::class);
    }

    //    /**
    //     * @return CompteLivretTable[] Returns an array of CompteLivretTable objects
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

    //    public function findOneBySomeField($value): ?CompteLivretTable
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
