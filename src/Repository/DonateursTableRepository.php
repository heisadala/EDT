<?php

namespace App\Repository;

use App\Entity\DonateursTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\Database;

/**
 * @extends ServiceEntityRepository<DonateursTable>
 *
 * @method DonateursTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method DonateursTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method DonateursTable[]    findAll()
 * @method DonateursTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DonateursTableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DonateursTable::class);
    }

    private function get_connection ()
    {
        return $this->getEntityManager()->getConnection();
    }

    public function set_table_name($table_name) 
    {
        $entityManager = $this->getEntityManager();
        $classMetaData = $entityManager->getClassMetadata(DonateursTable::class);
        $entityManager->clear();
        $classMetaData->setTableName($table_name);
    }

    public function send_sql_update_cmd($sql_cmd)
    {
        $db = new Database;
        $db->send_sql_update_cmd($this->get_connection(), $sql_cmd);
    }

    //    /**
    //     * @return DonateursTable[] Returns an array of DonateursTable objects
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

    //    public function findOneBySomeField($value): ?DonateursTable
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
