<?php

namespace App\Repository;

use App\Entity\ProjetsDevisTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\Database;

/**
 * @extends ServiceEntityRepository<ProjetsDevisTable>
 *
 * @method ProjetsDevisTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjetsDevisTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjetsDevisTable[]    findAll()
 * @method ProjetsDevisTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjetsDevisTableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjetsDevisTable::class);
    }

    function get_connection ()
    {
        return $this->getEntityManager()->getConnection();
    }
    public function fetch_column_unique_value($table_name, $column_name): array
    {
        $db = new Database;
        return ($db->fetch_column_unique_value($this->get_connection(), $table_name, $column_name));
    }    //    /**
    //     * @return ProjetsDevisTable[] Returns an array of ProjetsDevisTable objects
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

    //    public function findOneBySomeField($value): ?ProjetsDevisTable
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
