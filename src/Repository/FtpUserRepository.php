<?php

namespace App\Repository;

use App\Entity\FtpUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
#use Pagerfanta\Adapter\DoctrineORMAdapter;

/**
 * @method FtpUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method FtpUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method FtpUser[]    findAll()
 * @method FtpUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FtpUserRepository extends ServiceEntityRepository
{
	private $minimum_uid = 10001;

    public function __construct(RegistryInterface $registry, ParameterBagInterface $params)
    {
        parent::__construct($registry, FtpUser::class);
		$this->params = $params;
    }

//    /**
//     * @return FtpUser[] Returns an array of FtpUser objects
//     */

    public function findByGroupId($id_group)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.ftpgroup = :val')
            ->setParameter('val', $id_group)
            ->orderBy('u.username', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByGroupIdPaginator($id_group)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.ftpgroup = :val')
            ->setParameter('val', $id_group)
            ->orderBy('u.username', 'ASC')
            ->getQuery() ;
    }

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

    public function getNextUserId() {

		$nextid = $this->params->get('ftp_user_id');

		if ( $nextid === 'auto' ) {
			$nextid = $this->createQueryBuilder('u')
        	    ->select('MAX(u.uid) + 1')
        	    ->getQuery()
        	    ->getSingleScalarResult();

        	if ( is_null($nextid)) $nextid = $this->minimum_uid;
		}
        return $nextid;
    }
}
