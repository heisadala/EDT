<?php

namespace App\Repository;

use App\Entity\MarcheNoelTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\Database;

/**
 * @extends ServiceEntityRepository<MarcheNoelTable>
 */
class MarcheNoelTableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MarcheNoelTable::class);
    }
    private function get_connection ()
    {
        return $this->getEntityManager()->getConnection();
    }
    public function set_table_name($table_name) 
    {
        $entityManager = $this->getEntityManager();
        $classMetaData = $entityManager->getClassMetadata(MarcheNoelTable::class);
        $entityManager->clear();
        $classMetaData->setTableName($table_name);
    }

    public function send_sql_cmd($sql_cmd): array
    {
        $db = new Database;
        return $db->send_sql_cmd($this->get_connection(), $sql_cmd);
    }

    //    /**
    //     * @return MarcheNoelTable[] Returns an array of MarcheNoelTable objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?MarcheNoelTable
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
