<?php

namespace App\Entity;

use App\Repository\EnviosASRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnviosASRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class EnviosAS
{
     /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue(): void
    {
        $this->create_at = new \DateTime();
    }

    /**
     * @ORM\PrePersist
     */
    public function setUpdatedAtValue(): void
    {
        $this->update_at = new \DateTime();
    }

    const REGISTRO_EXITOSO = 'Registro un nuevo envio exitosamente!';
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $operacion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cajero;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $mes;

    /**
     * @ORM\Column(type="date")
     */
    private $anio;

    /**
     * @ORM\Column(type="integer")
     */
    private $total;

    /**
     * @ORM\Column(type="integer")
     */
    private $aporteA;

    /**
     * @ORM\Column(type="integer")
     */
    private $aporteB;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updateAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="enviosAS")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getOperacion(): ?string
    {
        return $this->operacion;
    }

    public function setOperacion(string $operacion): self
    {
        $this->operacion = $operacion;

        return $this;
    }

    public function getCajero(): ?string
    {
        return $this->cajero;
    }

    public function setCajero(string $cajero): self
    {
        $this->cajero = $cajero;

        return $this;
    }

    public function getMes(): ?string
    {
        return $this->mes;
    }

    public function setMes(string $mes): self
    {
        $this->mes = $mes;

        return $this;
    }

    public function getAnio(): ?\DateTimeInterface
    {
        return $this->anio;
    }

    public function setAnio(\DateTimeInterface $anio): self
    {
        $this->anio = $anio;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getAporteA(): ?int
    {
        return $this->aporteA;
    }

    public function setAporteA(int $aporteA): self
    {
        $this->aporteA = $aporteA;

        return $this;
    }

    public function getAporteB(): ?int
    {
        return $this->aporteB;
    }

    public function setAporteB(int $aporteB): self
    {
        $this->aporteB = $aporteB;

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

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    
    
    /** 
     * @ORM\PrePersist
     */
    public function setCreateAtValue()
    {
        $this->createAt = new \DateTime();
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setUpdateAtValue()
    {
        $this->updateAt = new \DateTime();
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
