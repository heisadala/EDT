<?php

namespace App\Repository;

use App\Entity\HomeTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HomeTable>
 *
 * @method HomeTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method HomeTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method HomeTable[]    findAll()
 * @method HomeTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HomeTableRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HomeTable::class);
        
        $db_app = $_SERVER['DATABASE_APP_NAME'];
        $home_table_name = $db_app . '.home_table';
        $entityManager = $this->getEntityManager();
        $classMetaData = $entityManager->getClassMetadata(HomeTable::class);
        $classMetaData->setTableName($home_table_name);
    }
    //    /**
    //     * @return HomeTable[] Returns an array of HomeTable objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('h.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?HomeTable
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
