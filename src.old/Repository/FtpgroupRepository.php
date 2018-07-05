<?php
namespace App\Repository;

use App\Entity\Ftpgroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Ftpgroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ftpgroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ftpgroup[]    findAll()
 * @method Ftpgroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FtpgroupRepository extends ServiceEntityRepository
{
    /**
     * @var int
     *
     */
	private $minimum_gid = 10001;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ftpgroup::class);
    }

    public function getNextGroupId() {
        $nextid = $this->createQueryBuilder('g')
            ->select('MAX(g.gid) + 1')
            ->getQuery()
            ->getSingleScalarResult();

        if ( is_null($nextid)) $nextid = $this->minimum_gid;
        return $nextid;
    }
//    /**
//     * @return Ftpgroup[] Returns an array of Ftpgroup objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ftpgroup
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
