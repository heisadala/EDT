<?php

namespace App\Repository;

use App\Entity\ProjectControllerTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProjectControllerTable>
 */
class ProjectControllerTableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectControllerTable::class);


        $db_app = $_SERVER['DATABASE_APP_NAME'];
        $controller_table_name = $db_app . '.project_controller_table';
        $entityManager = $this->getEntityManager();
        $classMetaData = $entityManager->getClassMetadata(ProjectControllerTable::class);
        $classMetaData->setTableName($controller_table_name);    

    }

    //    /**
    //     * @return ProjectControllerTable[] Returns an array of ProjectControllerTable objects
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

    //    public function findOneBySomeField($value): ?ProjectControllerTable
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
