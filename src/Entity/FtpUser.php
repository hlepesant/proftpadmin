<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FtpUserRepository")
 * @UniqueEntity("username")
 */
class FtpUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="integer", unique=true)
     */
    private $uid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $home;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $shell;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FtpGroup", inversedBy="members")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ftpgroup;

    public function getId()
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        #$this->password = $password;
        $this->password = "{md5}".base64_encode(pack("H*", md5($password)));

        return $this;
    }

    public function getUid(): ?int
    {
        return $this->uid;
    }

    public function setUid(int $uid): self
    {
        $this->uid = $uid;

        return $this;
    }

    public function getHome(): ?string
    {
        return $this->home;
    }

    public function setHome(string $home): self
    {
        $this->home = $home;

        return $this;
    }

    public function getShell(): ?string
    {
        return $this->shell;
    }

    public function setShell(string $shell): self
    {
        $this->shell = $shell;

        return $this;
    }

    public function getFtpgroup(): ?FtpGroup
    {
        return $this->ftpgroup;
    }

    public function setFtpgroup(?FtpGroup $ftpgroup): self
    {
        $this->ftpgroup = $ftpgroup;

        return $this;
    }
}
