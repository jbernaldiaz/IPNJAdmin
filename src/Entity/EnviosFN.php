<?php

namespace App\Entity;

use App\Repository\EnviosFNRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=EnviosFNRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *     fields={"mes", "anio"},
 *     errorPath="mes",
 *     message="Ya realizó envio de detalles ese mes del año"
 * )
 */
class EnviosFN
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
     * @ORM\Column(type="datetime")
     */
    private $fecha;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $operacion;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $cajero;

    /**
     *
     * @ORM\Column(type="string", length=50)
     */
    private $mes;

    /**
     * @ORM\Column(type="date")
     */
    private $anio;

    /**
     * @ORM\Column(type="datetime")
     */
    private $create_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $update_at;

    /**
     * @ORM\Column(type="integer")
     */
    private $dDiezmo;

    /**
     * @ORM\Column(type="integer")
     */
    private $fSolidario;

    /**
     * @ORM\Column(type="integer")
     */
    private $cuotaSocio;

    /**
     * @ORM\Column(type="integer")
     */
    private $DiezmoPersonal;

    /**
     * @ORM\Column(type="integer")
     */
    private $misionera;

    /**
     * @ORM\Column(type="integer")
     */
    private $rayos;

    /**
     * @ORM\Column(type="integer")
     */
    private $gavillas;

    /**
     * @ORM\Column(type="integer")
     */
    private $fmn;

    /**
     * @ORM\Column(type="integer")
     */
    private $total;



    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="enviosFN")
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

 /**
     * Set mes
     *
     * @param string $mes
     *
     * @return EnviosFN
     */
    public function setMes($mes)
    {
        $this->mes = $mes;

        return $this;
    }

    /**
     * Get mes
     *
     * @return string
     */
    public function getMes()
    {
        return $this->mes;
    }



    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->create_at;
    }

    public function setCreateAt(\DateTimeInterface $create_at): self
    {
        $this->create_at = $create_at;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->update_at;
    }

    public function setUpdateAt(\DateTimeInterface $update_at): self
    {
        $this->update_at = $update_at;

        return $this;
    }

    public function getDDiezmo(): ?int
    {
        return $this->dDiezmo;
    }

    public function setDDiezmo(int $dDiezmo): self
    {
        $this->dDiezmo = $dDiezmo;

        return $this;
    }

    public function getFSolidario(): ?int
    {
        return $this->fSolidario;
    }

    public function setFSolidario(int $fSolidario): self
    {
        $this->fSolidario = $fSolidario;

        return $this;
    }

    public function getCuotaSocio(): ?int
    {
        return $this->cuotaSocio;
    }

    public function setCuotaSocio(int $cuotaSocio): self
    {
        $this->cuotaSocio = $cuotaSocio;

        return $this;
    }

    public function getDiezmoPersonal(): ?int
    {
        return $this->DiezmoPersonal;
    }

    public function setDiezmoPersonal(int $DiezmoPersonal): self
    {
        $this->DiezmoPersonal = $DiezmoPersonal;

        return $this;
    }

    public function getMisionera(): ?int
    {
        return $this->misionera;
    }

    public function setMisionera(int $misionera): self
    {
        $this->misionera = $misionera;

        return $this;
    }

    public function getRayos(): ?int
    {
        return $this->rayos;
    }

    public function setRayos(int $rayos): self
    {
        $this->rayos = $rayos;

        return $this;
    }

    public function getGavillas(): ?int
    {
        return $this->gavillas;
    }

    public function setGavillas(int $gavillas): self
    {
        $this->gavillas = $gavillas;

        return $this;
    }

    public function getFmn(): ?int
    {
        return $this->fmn;
    }

    public function setFmn(int $fmn): self
    {
        $this->fmn = $fmn;

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


    /**
     * Set anio
     *
     * @param \Date $anio
     *
     * @return EnviosFN
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;

        return $this;
    }

    /**
     * Get anio
     *
     * @return \Date
     */
    public function getAnio()
    {
        return $this->anio;
    }

}
