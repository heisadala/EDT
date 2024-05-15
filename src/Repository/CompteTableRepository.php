<?php

namespace App\Repository;

use App\Entity\CompteTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompteTable>
 *
 * @method CompteTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompteTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompteTable[]    findAll()
 * @method CompteTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompteTableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompteTable::class);
    }

    //    /**
    //     * @return CompteTable[] Returns an array of CompteTable objects
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

    //    public function findOneBySomeField($value): ?CompteTable
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
