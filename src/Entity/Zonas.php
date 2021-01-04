<?php

namespace App\Entity;

use App\Repository\ZonasRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ZonasRepository::class)
 * @UniqueEntity("zona")
 */
class Zonas
{

    const REGISTRO_EXITOSO = 'Registro una nueva zona exitosamente!';

    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $zona;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="zonas")
     */
    private $user;

    /**
     * @return string String representation of this class
     */
    public function __toString()
    {
        return $this->zona;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getZona(): ?string
    {
        return $this->zona;
    }

    public function setZona(string $zona): self
    {
        $this->zona = $zona;

        return $this;
    }
}
