<?php

namespace App\Entity;

use App\Repository\ZonasRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ZonasRepository::class)
 */
class Zonas
{
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
