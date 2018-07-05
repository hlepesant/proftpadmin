<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Ftpgroup
 *
 * @ORM\Table(name="ftpgroup")
 * @ORM\Entity(repositoryClass="App\Repository\FtpgroupRepository")
 * @UniqueEntity("groupname")
 */
class Ftpgroup
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="groupname", type="string", length=255, unique=true)
     */
    private $groupname;

    /**
     * @ORM\Column(name="gid", type="integer", unique=true)
     */
    private $gid;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ftpuser", mappedBy="group")
     */
    private $members;

    public function __construct()
    {
        $this->members = new ArrayCollection();
    }


    public function getId()
    {
        return $this->id;
    }

    public function setGroupname($groupname): self
    {
        $this->groupname = mb_strtolower($groupname, 'UTF-8');

        return $this;
    }

    public function getGroupname(): ?string
    {
        return $this->groupname;
    }

    public function setGid($gid): self
    {
        $this->gid = $gid;

        return $this;
    }

    public function getGid(): ?integer
    {
        return $this->gid;
    }

    public function addMember(Ftpuser $member): self
    {
        $this->members[] = $member;
        if (!$this->members->contains($member)) {
            $this->members[] = $member;
            $member->setGroup($this);
        }

        return $this;
    }

    public function removeMember(Ftpuser $member): self
    {
        $this->members->removeElement($member);
        if ($this->members->contains($member)) {
            $this->members->removeElement($member);
            // set the owning side to null (unless already changed)
            if ($member->getGroup() === $this) {
                $member->setGroup(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getMembers(): Collection
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
