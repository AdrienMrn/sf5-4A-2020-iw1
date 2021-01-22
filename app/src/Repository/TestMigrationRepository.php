<?php

namespace App\Repository;

use App\Entity\TestMigration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TestMigration|null find($id, $lockMode = null, $lockVersion = null)
 * @method TestMigration|null findOneBy(array $criteria, array $orderBy = null)
 * @method TestMigration[]    findAll()
 * @method TestMigration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestMigrationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TestMigration::class);
    }

    // /**
    //  * @return TestMigration[] Returns an array of TestMigration objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TestMigration
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
