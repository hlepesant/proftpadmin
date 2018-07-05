<?php

namespace App\Repository;

use App\Entity\FtpGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FtpGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method FtpGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method FtpGroup[]    findAll()
 * @method FtpGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FtpGroupRepository extends ServiceEntityRepository
{
	private $minimum_gid = 10001;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FtpGroup::class);
    }

//    /**
//     * @return FtpGroup[] Returns an array of FtpGroup objects
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
    public function findOneBySomeField($value): ?FtpGroup
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getNextGroupId() {
        $nextid = $this->createQueryBuilder('g')
            ->select('MAX(g.gid) + 1')
            ->getQuery()
            ->getSingleScalarResult();

        if ( is_null($nextid)) $nextid = $this->minimum_gid;
        return $nextid;
    }
}
