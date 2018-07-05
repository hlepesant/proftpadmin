<?php

namespace App\Repository;

use App\Entity\FtpUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FtpUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method FtpUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method FtpUser[]    findAll()
 * @method FtpUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FtpUserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FtpUser::class);
    }

//    /**
//     * @return FtpUser[] Returns an array of FtpUser objects
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
    public function findOneBySomeField($value): ?FtpUser
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
