<?php

namespace ProftpBundle\Repository;

/**
 * FtpuserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FtpuserRepository extends \Doctrine\ORM\EntityRepository
{
    public function getNextUserId() {
        return $this->createQueryBuilder('u')
            ->select('MAX(u.uid) + 1')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
