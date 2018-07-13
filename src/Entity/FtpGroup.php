<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="App\Repository\FtpGroupRepository")
 * @UniqueEntity("groupname")
 */
class FtpGroup
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $groupname;

    /**
     * @ORM\Column(type="integer", unique=true)
     */
    private $gid;

    /**
     * @ORM\Column(type="boolean", options={"default" : 1})
     */
    private $active;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FtpUser", mappedBy="ftpgroup")
     */
    private $members;

    public function __construct()
    {
        $this->members = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->groupname;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getGroupname(): ?string
    {
        return $this->groupname;
    }

    public function setGroupname(string $groupname): self
    {
        $this->groupname = mb_strtolower($groupname, 'UTF-8');

        return $this;
    }

    public function getGid(): ?int
    {
        return $this->gid;
    }

    public function setGid(int $gid): self
    {
        $this->gid = $gid;

        return $this;
    }

    /**
     * @return Collection|FtpUser[]
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(FtpUser $member): self
    {
        if (!$this->members->contains($member)) {
            $this->members[] = $member;
            $member->setFtpgroup($this);
        }

        return $this;
    }

    public function removeMember(FtpUser $member): self
    {
        if ($this->members->contains($member)) {
            $this->members->removeElement($member);
            // set the owning side to null (unless already changed)
            if ($member->getFtpgroup() === $this) {
                $member->setFtpgroup(null);
            }
        }

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
