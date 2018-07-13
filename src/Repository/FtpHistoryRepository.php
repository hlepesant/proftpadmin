<?php

namespace App\Repository;

use App\Entity\FtpHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FtpHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method FtpHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method FtpHistory[]    findAll()
 * @method FtpHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FtpHistoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FtpHistory::class);
    }

//    /**
//     * @return FtpHistory[] Returns an array of FtpHistory objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FtpHistory
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
