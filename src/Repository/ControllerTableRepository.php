<?php

namespace App\Repository;

use App\Entity\ControllerTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ControllerTable>
 *
 * @method ControllerTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method ControllerTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method ControllerTable[]    findAll()
 * @method ControllerTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ControllerTableRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ControllerTable::class);
        
        $db_app = $_SERVER['DATABASE_APP_NAME'];
        $controller_table_name = $db_app . '.controller_table';
        $entityManager = $this->getEntityManager();
        $classMetaData = $entityManager->getClassMetadata(ControllerTable::class);
        $classMetaData->setTableName($controller_table_name);
    }
    //    /**
    //     * @return ControllerTable[] Returns an array of ControllerTable objects
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

    //    public function findOneBySomeField($value): ?ControllerTable
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
