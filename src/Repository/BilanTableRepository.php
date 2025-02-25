<?php

namespace App\Repository;

use App\Entity\BilanTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\Database;

/**
 * @extends ServiceEntityRepository<BilanTable>
 */
class BilanTableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BilanTable::class);
    }

    private function get_connection ()
    {
        return $this->getEntityManager()->getConnection();
    }

    public function set_table_name($table_name) 
    {
        $entityManager = $this->getEntityManager();
        $classMetaData = $entityManager->getClassMetadata(BilanTable::class);
        $entityManager->clear();
        $classMetaData->setTableName($table_name);
    }

    public function send_sql_cmd($sql_cmd): array
    {
        $db = new Database;
        return ($db->send_sql_cmd($this->get_connection(), $sql_cmd));
    }
    
    public function send_sql_update_cmd($sql_cmd)
    {
        $db = new Database;
        $db->send_sql_update_cmd($this->get_connection(), $sql_cmd);
    }
    
    public function update_montant($table_name, $column_name, $value)
    {
        $db = new Database;
        $db->update_bilan_montant($this->get_connection(), 
                                $table_name, 
                                $column_name, 
                                $value);
    }
    //    /**
    //     * @return BilanTable[] Returns an array of BilanTable objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?BilanTable
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
