<?php

namespace App\Repository;

use App\Entity\AffectationTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\Database;

/**
 * @extends ServiceEntityRepository<AffectationTable>
 *
 * @method AffectationTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method AffectationTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method AffectationTable[]    findAll()
 * @method AffectationTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AffectationTableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AffectationTable::class);
    }
    function get_connection ()
    {
        return $this->getEntityManager()->getConnection();
    }
    public function send_sql_cmd($sql_cmd): array
    {
        $db = new Database;
        return ($db->send_sql_cmd($this->get_connection(), $sql_cmd));
    }


    //    /**
    //     * @return AffectationTable[] Returns an array of AffectationTable objects
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

    //    public function findOneBySomeField($value): ?AffectationTable
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
