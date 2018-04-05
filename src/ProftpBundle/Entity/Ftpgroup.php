<?php

namespace ProftpBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Ftpgroup
 *
 * @ORM\Table(name="ftpgroup")
 * @ORM\Entity(repositoryClass="ProftpBundle\Repository\FtpgroupRepository")
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
        $this->groupname = $groupname;

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

    public function __toString()
    {
        return $this->groupname;
    }
}
