<?php

namespace App\Repository;

use App\Entity\CompteChequesTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\Database;

/**
 * @extends ServiceEntityRepository<CompteChequesTable>
 *
 * @method CompteChequesTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompteChequesTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompteChequesTable[]    findAll()
 * @method CompteChequesTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompteChequesTableRepository extends ServiceEntityRepository
{
    private ?string $compte_cheques_table_name = 'compte_cheques_table';
    private ?string $short_name = 'c';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompteChequesTable::class);
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
    public function fetch_header_fields_from_table($table_name): array
    {
        $db = new Database;
        return ($db->fetch_header_fields_from_table($this->get_connection(), $table_name));
    }

    public function get_pk_name($table_name): string
    {
        $db = new Database;
        return ($db->get_pk_name($this->get_connection(), $table_name));
    }

    public function fetch_class_from_table_ordered ($table_name, $ordered_by, $sort_order)
    {
        $db = new Database;
        return ($db->fetch_class_from_table_ordered($this->get_connection(), $table_name, 
                                                    $ordered_by, $sort_order));

    }
    public function fetch_class_from_table_all_ordered ($table_name, $archive, $userlist, $ordered_by, $sort_order)
    {
        $db = new Database;
        return ($db->fetch_class_from_table_all_ordered($this->get_connection(), $table_name, $archive,
                                                    $userlist, $ordered_by, $sort_order));

    }
    public function fetch_class_from_table_user_ordered ($table_name, $user, $archive, $ordered_by, $sort_order)
    {
        $db = new Database;
        return ($db->fetch_class_from_table_user_ordered($this->get_connection(), $table_name, $user,
                                                    $archive, $ordered_by, $sort_order));

    }
    public function fetch_column_unique_value($table_name, $column_name): array
    {
        $db = new Database;
        return ($db->fetch_column_unique_value($this->get_connection(), $table_name, $column_name));
    }

    function join_project_and_prestataire($t1, 
                                            $t1_id,
                                            $t2,
                                            $t2_key, $ordered_by, $sort_order): array
    {

        $db = new Database;
        return ($db->join_project_and_prestataire($this->get_connection(), $t1, 
                                                    $t1_id,
                                                    $t2,
                                                    $t2_key, $ordered_by, $sort_order
                                                    ));
    }


    function join_compte_project_and_prestataire($selectlist, 
                                                    $t1_id,
                                                    $t2,
                                                    $t2_id, $t2_key,
                                                    $t3,
                                                    $t3_key, $ordered_by, $sort_order): array
    {

        $db = new Database;
        return ($db->join_compte_project_and_prestataire($this->get_connection(), 
                                                            $this->compte_cheques_table_name, 
                                                            $this->short_name, 
                                                            $selectlist,
                                                            $t2,
                                                            $t2_id, $t2_key,
                                                            $t3,
                                                            $t3_key, $ordered_by, $sort_order
                ));
    }
    function join_three_tables_with_filter($t1, 
                                            $t1_id,
                                            $t2,
                                            $t2_id, $t2_key,
                                            $t3,
                                            $t3_key, $column, $filter): array
    {

        $db = new Database;
        return $db->join_three_tables_with_filter($this->get_connection(), $t1, 
                                                            $t1_id,
                                                            $t2,
                                                            $t2_id, $t2_key,
                                                            $t3,
                                                            $t3_key, $column, $filter
                );
    }

    function join_n_tables_with_filter($number, $t1, $join_table,
                                        $column, $filter)
    {   
        $db = new Database;
        return $db->join_n_tables_with_filter($this->get_connection(), $number, $t1, 
                                                            $join_table, $column, $filter
                );
    }

    function select_all_from_where($table_id, $id)
    {   
        $db = new Database;
        return $db->select_all_from_where($this->get_connection(), 
                                            'compte_cheques_table', 
                                            $table_id, $id
                                        );
    }

    //    /**
        //    /**
    //     * @return CompteChequesTable[] Returns an array of CompteChequesTable objects
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

    //    public function findOneBySomeField($value): ?CompteChequesTable
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
