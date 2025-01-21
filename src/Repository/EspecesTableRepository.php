<?php

namespace App\Repository;

use App\Entity\EspecesTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\Database;

/**
 * @extends ServiceEntityRepository<EspecesTable>
 *
 * @method EspecesTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method EspecesTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method EspecesTable[]    findAll()
 * @method EspecesTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EspecesTableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EspecesTable::class);
    }
    function get_connection ()
    {
        return $this->getEntityManager()->getConnection();
    }

    function set_table_name($table_name) 
    {
        $entityManager = $this->getEntityManager();
        $classMetaData = $entityManager->getClassMetadata(EspecesTable::class);
        $entityManager->clear();
        $classMetaData->setTableName($table_name);
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

    public function send_sql_cmd($sql_cmd): array
    {
        $db = new Database;
        return ($db->send_sql_cmd($this->get_connection(), $sql_cmd));
    }
    function select_all_from_where($table_name, $table_id, $id)
    {   
        $db = new Database;
        return $db->select_all_from_where($this->get_connection(), 
                                            $table_name, 
                                            $table_id, $id
                                        );
    }
    //    /**
    //     * @return CompteFondsDeCaissesTable[] Returns an array of CompteFondsDeCaissesTable objects
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

    //    public function findOneBySomeField($value): ?CompteFondsDeCaissesTable
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
