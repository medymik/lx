<?php

namespace App\Repository;

use App\Entity\Appelle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Appelle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Appelle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Appelle[]    findAll()
 * @method Appelle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppelleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Appelle::class);
    }

    // /**
    //  * @return Appelle[] Returns an array of Appelle objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Appelle
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
