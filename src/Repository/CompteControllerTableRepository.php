<?php

namespace App\Repository;

use App\Entity\CompteControllerTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompteControllerTable>
 *
 * @method CompteTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompteTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompteTable[]    findAll()
 * @method CompteTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompteControllerTableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompteControllerTable::class);

        $db_app = $_SERVER['DATABASE_APP_NAME'];
        $controller_table_name = $db_app . '.compte_controller_table';
        $entityManager = $this->getEntityManager();
        $classMetaData = $entityManager->getClassMetadata(CompteControllerTable::class);
        $classMetaData->setTableName($controller_table_name);    }

    //    /**
    //     * @return CompteTable[] Returns an array of CompteTable objects
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

    //    public function findOneBySomeField($value): ?CompteTable
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
