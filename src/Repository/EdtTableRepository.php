<?php

namespace App\Repository;

use App\Entity\EdtTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\Database;


 /**
 * @extends ServiceEntityRepository<EdtTable>
 *
 * @method EdtTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method EdtTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method EdtTable[]    findAll()
 * @method EdtTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class EdtTableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EdtTable::class);
    }
    function get_connection ()
    {
        return $this->getEntityManager()->getConnection();
    }

    function set_table_name($table_name) 
    {
        $entityManager = $this->getEntityManager();
        $classMetaData = $entityManager->getClassMetadata(EdtTable::class);
        $entityManager->clear();

        $classMetaData->setTableName($table_name);
    }
    function clear() 
    {
        $entityManager = $this->getEntityManager();
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
    public function update_montant($table_name, $column_name, $value, $id)
    {
        $db = new Database;
        $db->update_edt_montant($this->get_connection(), 
                                $table_name, 
                                $column_name, 
                                $value, 
                                $id);
        // $this->getEntityManager()->flush();
    }
    public function update_test_montant($table_name, $column_name, $value, $id)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->getRepository(EdtTable::class)->set_table_name($table_name);
        $product = $entityManager->getRepository(EdtTable::class)->find($id);        
dd($product);
    }
    //    /**
    //     * @return EdtTable[] Returns an array of EdtTable objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?EdtTable
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
