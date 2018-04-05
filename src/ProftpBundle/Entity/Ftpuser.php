<?php

namespace ProftpBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ftpuser
 *
 * @ORM\Table(name="ftpuser")
 * @ORM\Entity(repositoryClass="ProftpBundle\Repository\FtpuserRepository")
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
     * @ORM\ManyToOne(targetEntity="Ftpgroup", inversedBy="members")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     */
    private $group;


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
        $this->password = $password;

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

    /**
     * Set group
     *
     * @param \ProftpBundle\Entity\Ftpgroup $group
     *
     * @return Ftpuser
     */
    public function setGroup(\ProftpBundle\Entity\Ftpgroup $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \ProftpBundle\Entity\Ftpgroup
     */
    public function getGroup()
    {
        return $this->group;
    }
}
