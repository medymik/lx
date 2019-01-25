<?php

namespace App\Repository;

use App\Entity\MicroPaiement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MicroPaiement|null find($id, $lockMode = null, $lockVersion = null)
 * @method MicroPaiement|null findOneBy(array $criteria, array $orderBy = null)
 * @method MicroPaiement[]    findAll()
 * @method MicroPaiement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MicroPaiementRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MicroPaiement::class);
    }

    // /**
    //  * @return MicroPaiement[] Returns an array of MicroPaiement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MicroPaiement
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
