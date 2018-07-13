<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FtpHistoryRepository")
 */
class FtpHistory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $client_ip;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $operation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $file;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FtpUser", inversedBy="ftpHistories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ftpuser;

    public function getId()
    {
        return $this->id;
    }

    public function getClientIp(): ?string
    {
        return $this->client_ip;
    }

    public function setClientIp(string $client_ip): self
    {
        $this->client_ip = $client_ip;

        return $this;
    }

    public function getServerIp(): ?string
    {
        return $this->server_ip;
    }

    public function setServerIp(?string $server_ip): self
    {
        $this->server_ip = $server_ip;

        return $this;
    }

    public function getOperation(): ?string
    {
        return $this->operation;
    }

    public function setOperation(?string $operation): self
    {
        $this->operation = $operation;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(string $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getFtpuser(): ?FtpUser
    {
        return $this->ftpuser;
    }

    public function setFtpuser(?FtpUser $ftpuser): self
    {
        $this->ftpuser = $ftpuser;

        return $this;
    }
}
