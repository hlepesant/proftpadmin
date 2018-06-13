<?php

namespace ProftpBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Ftpgroup
 *
 * @ORM\Table(name="ftpgroup")
 * @ORM\Entity(repositoryClass="ProftpBundle\Repository\FtpgroupRepository")
 * @UniqueEntity("groupname")
 */
class Ftpgroup
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="groupname", type="string", length=255, unique=true)
     */
    private $groupname;

    /**
     * @var int
     *
     * @ORM\Column(name="gid", type="integer", unique=true)
     */
    private $gid;

    /**
     * @ORM\OneToMany(targetEntity="Ftpuser", mappedBy="group")
     */
    private $members;

    /**
     * @var int
     *
     */
	private $minimum_gid = 10001;

    public function __construct()
    {
        $this->members = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set groupname
     *
     * @param string $groupname
     *
     * @return Ftpgroup
     */
    public function setGroupname($groupname)
    {
        $this->groupname = mb_strtolower($groupname, 'UTF-8');

        return $this;
    }

    /**
     * Get groupname
     *
     * @return string
     */
    public function getGroupname()
    {
        return $this->groupname;
    }

    /**
     * Set gid
     *
     * @param integer $gid
     *
     * @return Ftpgroup
     */
    public function setGid($gid)
    {
		if ( $gid == "" ) $gid = $this->minimum_gid;
        $this->gid = $gid;

        return $this;
    }

    /**
     * Get gid
     *
     * @return int
     */
    public function getGid()
    {
        return $this->gid;
    }

    /**
     * Add member
     *
     * @param \ProftpBundle\Entity\Ftpuser $member
     *
     * @return Ftpgroup
     */
    public function addMember(\ProftpBundle\Entity\Ftpuser $member)
    {
        $this->members[] = $member;

        return $this;
    }

    /**
     * Remove member
     *
     * @param \ProftpBundle\Entity\Ftpuser $member
     */
    public function removeMember(\ProftpBundle\Entity\Ftpuser $member)
    {
        $this->members->removeElement($member);
    }

    /**
     * Get members
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMembers()
    {
        return $this->members;
    }


    /**
     * __toString
     *
     */
    public function __toString()
    {
        return $this->groupname;
    }
}