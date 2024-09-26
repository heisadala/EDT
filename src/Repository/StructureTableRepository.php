<?php

namespace App\Repository;

use App\Entity\StructureTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\Database;

/**
 * @extends ServiceEntityRepository<StructureTable>
 *
 * @method StructureTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method StructureTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method StructureTable[]    findAll()
 * @method StructureTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StructureTableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StructureTable::class);
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
    //     * @return StructureTable[] Returns an array of StructureTable objects
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

    //    public function findOneBySomeField($value): ?StructureTable
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
