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
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompteChequesTable::class);
    }

    function get_connection ()
    {
        return $this->getEntityManager()->getConnection();
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
