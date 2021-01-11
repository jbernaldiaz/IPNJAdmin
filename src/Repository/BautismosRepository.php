<?php

namespace App\Repository;

use App\Entity\Bautismos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Bautismos|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bautismos|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bautismos[]    findAll()
 * @method Bautismos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BautismosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bautismos::class);
    }

    public function TodosLosBautismos()
    {
        return $this->createQueryBuilder('e')
            ->getQuery()
        ;
    }


    // /**
    //  * @return Bautismos[] Returns an array of Bautismos objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Bautismos
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
