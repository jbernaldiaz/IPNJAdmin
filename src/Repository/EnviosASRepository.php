<?php

namespace App\Repository;

use App\Entity\EnviosAS;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnviosAS|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnviosAS|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnviosAS[]    findAll()
 * @method EnviosAS[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnviosASRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnviosAS::class);
    }

    // /**
    //  * @return EnviosAS[] Returns an array of EnviosAS objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EnviosAS
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
