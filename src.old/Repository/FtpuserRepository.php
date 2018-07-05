<?php
namespace App\Repository;

use App\Entity\Ftpuser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Ftpuser|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ftpuser|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ftpuser[]    findAll()
 * @method Ftpuser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FtpuserRepository extends ServiceEntityRepository
{
    /**
     * @var int
     *
     */
	private $minimum_uid = 10001;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ftpuser::class);
    }

    public function getNextUserId() {
        $nextid = $this->createQueryBuilder('u')
            ->select('MAX(u.uid) + 1')
            ->getQuery()
            ->getSingleScalarResult();

        if ( is_null($nextid)) $nextid = $this->minimum_uid;
        return $nextid;
    }
/*
	public function findUsersForGroup($group_id) {

		$users = $this->createQueryBuilder('u')
			->andWhere('u.group = :group_id')
			->setParameter('group_id', $group_id)
			->innerJoin('u.group', 'g')
			->addSelect('g')
			->getQuery();

		return $users->execute();
	}
 */

//    /**
//     * @return Product[] Returns an array of Product objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
