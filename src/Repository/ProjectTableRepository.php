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
    private ?string $project_table_name = 'project_table';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectTable::class);
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


    public function select_from_inner_on($table_name, $select, $id)
    {
        $db = new Database;
        return ($db->select_from_inner_on($this->get_connection(), 
            $table_name, $select, $id));
    }
    public function fetch_column_unique_value($table_name, $column_name): array
    {
        $db = new Database;
        return ($db->fetch_column_unique_value($this->get_connection(), $table_name, $column_name));
    }
    
    public function update_f_montant($column_name, $value, $id)
    {
        $db = new Database;
        $db->update_f_montant($this->get_connection(), 
                                $this->project_table_name, 
                                $column_name, 
                                $value, 
                                $id);
    }
    
    public function get_max_id()
    {
        $db = new Database;
        return $db->get_max_id($this->get_connection(), $this->project_table_name, 'proj_id')[0]["MAX(proj_id)"];
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
