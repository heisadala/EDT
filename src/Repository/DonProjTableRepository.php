<?php

namespace App\Repository;

use App\Entity\DonProjTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\Database;

/**
 * @extends ServiceEntityRepository<DonProjTable>
 *
 * @method DonProjTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method DonProjTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method DonProjTable[]    findAll()
 * @method DonProjTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DonProjTableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DonProjTable::class);
    }
    private function get_connection ()
    {
        return $this->getEntityManager()->getConnection();
    }

    public function set_table_name($table_name) 
    {
        $entityManager = $this->getEntityManager();
        $classMetaData = $entityManager->getClassMetadata(DonProjTable::class);
        $entityManager->clear();
        $classMetaData->setTableName($table_name);
    }

    public function send_sql_cmd($sql_cmd): array
    {
        $db = new Database;
        return ($db->send_sql_cmd($this->get_connection(), $sql_cmd));
    }
    
    //    /**
    //     * @return DonProjTable[] Returns an array of DonProjTable objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?DonProjTable
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
