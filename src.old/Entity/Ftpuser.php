<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * Ftpuser
 *
 * @ORM\Table(name="ftpuser")
 * @ORM\Entity(repositoryClass="App\Repository\FtpuserRepository")
 * @UniqueEntity("username")
 */
class Ftpuser
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
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var int
     *
     * @ORM\Column(name="uid", type="integer")
     */
    private $uid;

    /**
     * @var string
     *
     * @ORM\Column(name="home", type="string", length=255)
     */
    private $home;

    /**
     * @var string
     *
     * @ORM\Column(name="shell", type="string", length=50)
     */
    private $shell;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ftpgroup", inversedBy="members")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id",nullable=false)
     */
    private $group;

    /**
     * @var int
     *
     */
	private $minimum_uid = 10001;

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
     * Set username
     *
     * @param string $username
     *
     * @return Ftpuser
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Ftpuser
     */
    public function setPassword($password)
    {
        //$this->password = $password;
        $this->password = "{md5}".base64_encode(pack("H*", md5($password)));

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set uid
     *
     * @param integer $uid
     *
     * @return Ftpuser
     */
    public function setUid($uid)
    {
		if ( $uid == "" ) $uid = $this->minimum_uid;
        $this->uid = $uid;

        return $this;
    }

    /**
     * Get uid
     *
     * @return int
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Set home
     *
     * @param string $home
     *
     * @return Ftpuser
     */
    public function setHome($home)
    {
        $this->home = $home;

        return $this;
    }

    /**
     * Get home
     *
     * @return string
     */
    public function getHome()
    {
        return $this->home;
    }

    /**
     * Set shell
     *
     * @param string $shell
     *
     * @return Ftpuser
     */
    public function setShell($shell)
    {
        $this->shell = $shell;

        return $this;
    }

    /**
     * Get shell
     *
     * @return string
     */
    public function getShell()
    {
        return $this->shell;
    }

    public function getGroup(): ?Ftpgroup
    {
        return $this->group;
    }

    public function setGroup(?Ftpgroup $group): self
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Ftpuser
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Ftpuser
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }
}
