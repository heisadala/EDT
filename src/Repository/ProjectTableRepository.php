<?php

namespace App\Repository;

use App\Entity\ProjectTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\Database;

/**
 * @extends ServiceEntityRepository<ProjectTable>
 *
 * @method ProjectTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectTable[]    findAll()
 * @method ProjectTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectTableRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectTable::class);
    }
    private function get_connection ()
    {
        return $this->getEntityManager()->getConnection();
    }
    public function set_table_name($table_name) 
    {
        $entityManager = $this->getEntityManager();
        $classMetaData = $entityManager->getClassMetadata(ProjectTable::class);
        $entityManager->clear();
        $classMetaData->setTableName($table_name);
    }

    public function send_sql_cmd($sql_cmd): array
    {
        $db = new Database;
        return $db->send_sql_cmd($this->get_connection(), $sql_cmd);
    }
    public function send_sql_update_cmd($sql_cmd)
    {
        $db = new Database;
        $db->send_sql_update_cmd($this->get_connection(), $sql_cmd);
    }
    public function get_affectation_list ($table_name)
    {
        $db = new Database;
        $db_common = $_SERVER['DATABASE_COMMON_NAME'];

        $sql_cmd = "SELECT a.nom AS affectation FROM " . $table_name . 
                    " p JOIN " . $db_common . ".affectation_table a ON p.affectation_id = a.affectation_id
                      WHERE p.affectation_id > 0 GROUP BY a.nom ORDER BY a.nom ASC";
        return ($db->send_sql_cmd($this->get_connection(), $sql_cmd));
    }




    public function fetch_column_unique_value($table_name, $column_name): array
    {
        $db = new Database;
        return ($db->fetch_column_unique_value($this->get_connection(), $table_name, $column_name));
    }


    public function update_f_montant($table_name, $column_name, $value, $id)
    {
        $db = new Database;
        $db->update_f_montant($this->get_connection(), 
                                $table_name, 
                                $column_name, 
                                $value, 
                                $id);
    }

    public function update_c_montant($table_name, $column_name, $value, $id)
    {
        $db = new Database;
        $db->update_c_montant($this->get_connection(), 
                                $table_name, 
                                $column_name, 
                                $value, 
                                $id);
    }

    public function update_proj_montant($table_name, $column_name, $value, $id)
    {
        $db = new Database;
        $db->update_proj_montant($this->get_connection(), 
                                $table_name, 
                                $column_name, 
                                $value, 
                                $id);
    }

    //    /**
    //     * @return ProjectTable[] Returns an array of ProjectTable objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ProjectTable
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
