<?php

namespace App\Repository;

use App\Entity\YearTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\Database;

/**
 * @extends ServiceEntityRepository<YearTable>
 */
class YearTableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, YearTable::class);
        
        $db_app = $_SERVER['DATABASE_APP_NAME'];
        $year_table_name = $db_app . '.year_table';
        $entityManager = $this->getEntityManager();
        $classMetaData = $entityManager->getClassMetadata(YearTable::class);
        $classMetaData->setTableName($year_table_name);
    }
    function get_connection ()
    {
        return $this->getEntityManager()->getConnection();
    }

    public function update($table_name, $column_name, $value, $id_column, $id)
    {
        $db = new Database;
        $db->update($this->get_connection(), 
                                $table_name, 
                                $column_name, 
                                $value, 
                                $id_column, 
                                $id);
    }

    //    /**
    //     * @return YearTable[] Returns an array of YearTable objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('y')
    //            ->andWhere('y.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('y.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?YearTable
    //    {
    //        return $this->createQueryBuilder('y')
    //            ->andWhere('y.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
