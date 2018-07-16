<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\GeneratedValue(strategy="IDENTITY")
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
     * @ORM\Column(type="datetime", nullable=true)
	 */
	private $last_login;

    /**
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    private $login_count;

    /**
     * @ORM\Column(type="boolean", options={"default" : 1})
     */
    private $active;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FtpGroup", inversedBy="members")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ftpgroup;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FtpHistory", mappedBy="ftpuser", orphanRemoval=true)
     */
    private $ftpHistories;

    public function __construct()
    {
        $this->ftpHistories = new ArrayCollection();
    }

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
        #$this->password = "{md5}".base64_encode(pack("H*", md5($password)));
		#$this->password = "{Scrypt}".password_hash($password, PASSWORD_DEFAULT);
		#$this->password = "{crypt}".password_hash($password, PASSWORD_BCRYPT);
		$this->password = $this->hash_password($password);

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

    public function getLoginCount(): ?int
    {
        return $this->login_count;
    }

    public function setLoginCount(int $login_count): self
    {
        $this->login_count = $login_count;

        return $this;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->last_login;
    }

    public function setLastLogin(?\DateTimeInterface $last_login): self
    {
        $this->last_login = $last_login;

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

    /**
     * @return Collection|FtpHistory[]
     */
    public function getFtpHistories(): Collection
    {
        return $this->ftpHistories;
    }

    public function addFtpHistory(FtpHistory $ftpHistory): self
    {
        if (!$this->ftpHistories->contains($ftpHistory)) {
            $this->ftpHistories[] = $ftpHistory;
            $ftpHistory->setUserId($this);
        }

        return $this;
    }

    public function removeFtpHistory(FtpHistory $ftpHistory): self
    {
        if ($this->ftpHistories->contains($ftpHistory)) {
            $this->ftpHistories->removeElement($ftpHistory);
            // set the owning side to null (unless already changed)
            if ($ftpHistory->getUserId() === $this) {
                $ftpHistory->setUserId(null);
            }
        }

        return $this;
    }


	private function hash_password($password) // SSHA with random 4-character salt
	{
		#$salt = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',4)),0,4);
		#return '{SSHA}' . base64_encode(sha1( $password.$salt, TRUE ). $salt);

		$salt = substr(sha1(rand()), 0, 16);
		return "{SHA256}" . base64_encode(hash('sha256', $password, true));

	}
}
