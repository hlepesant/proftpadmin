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

    public function findByUserId($id_user)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.ftpuser = :val')
            ->setParameter('val', $id_user)
            ->orderBy('h.date', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

	/*
	 * SELECT username, file, operation, status, ftp_history.date as date FROM ftp_history INNER JOIN ftp_user ON ftp_history.ftpuser_id = ftp_user.id WHERE ftp_user.id = 104 AND ftp_user.ftpgroup_id = 4;
	 */
	public function findByUserAndGroupId($id_user, $id_group)
	{
        return $this->createQueryBuilder('h')
			->innerJoin('h.ftpuser', 'u')
			->addSelect('u')
			->innerJoin('u.ftpgroup', 'g')
			->addSelect('g')
            ->andWhere('h.ftpuser = :idu')
            ->andWhere('g.id = :idg')
            ->setParameter('idu', $id_user)
            ->setParameter('idg', $id_group)
            ->orderBy('h.date', 'DESC')
            ->getQuery()
            ->getResult()
        ;
	}

	public function findByUserAndGroupIdPaginator($id_user, $id_group)
	{
        return $this->createQueryBuilder('h')
			->innerJoin('h.ftpuser', 'u')
			->addSelect('u')
			->innerJoin('u.ftpgroup', 'g')
			->addSelect('g')
            ->andWhere('h.ftpuser = :idu')
            ->andWhere('g.id = :idg')
            ->setParameter('idu', $id_user)
            ->setParameter('idg', $id_group)
            ->orderBy('h.date', 'DESC')
            ->getQuery()
        ;
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
