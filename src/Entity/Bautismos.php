<?php

namespace App\Entity;

use App\Repository\BautismosRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BautismosRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Bautismos
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fechaAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bautizo;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fotos;



    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="baustismos")
     */
    private $user;





    /** 
     * @ORM\PrePersist
     */
    public function setCreateAtValue()
    {
        $this->createAt = new \DateTime();
    }





    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaAt(): ?\DateTimeInterface
    {
        return $this->fechaAt;
    }

    public function setFechaAt(\DateTimeInterface $fechaAt): self
    {
        $this->fechaAt = $fechaAt;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getBautizo(): ?string
    {
        return $this->bautizo;
    }

    public function setBautizo(string $bautizo): self
    {
        $this->bautizo = $bautizo;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getFotos(): ?string
    {
        return $this->fotos;
    }

    public function setFotos(?string $fotos): self
    {
        $this->fotos = $fotos;

        return $this;
    }

    /**
     * Get the value of user
     */ 
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */ 
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }
}
