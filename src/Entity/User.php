<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    
    const REGISTRO_EXITOSO = 'Registro un nuevo usuario exitosamente!';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;
    
    /**
     * @var string
     *
     * @ORM\Column(name="iglesia", type="string", length=100)
     */
    private $iglesia;  

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Zonas", inversedBy="user")
     */
    private $zonas;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EnviosFN", mappedBy="user")
     */
    private $enviosFN;


    
    
    public function __construct()
    {
        $this->iglesias = new ArrayCollection();
        $this->isActive = true;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER, ROLE_ADMIN, ROLE_SUPER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }


    


    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    

    /**
     * Get the value of iglesia
     *
     * @return  string
     */ 
    public function getIglesia()
    {
        return $this->iglesia;
    }

    /**
     * Set the value of iglesia
     *
     * @param  string  $iglesia
     *
     * @return  self
     */ 
    public function setIglesia(string $iglesia)
    {
        $this->iglesia = $iglesia;

        return $this;
    }

    /**
     * Get the value of isActive
     *
     * @return  boolean
     */ 
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set the value of isActive
     *
     * @param  boolean  $isActive
     *
     * @return  User
     */ 
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get the value of zonas
     */ 
    public function getZonas()
    {
        return $this->zonas;
    }

    /**
     * Set the value of zonas
     *
     * @return  self
     */ 
    public function setZonas($zonas)
    {
        $this->zonas = $zonas;

        return $this;
    }

    public function __toString()
    {
        return $this->iglesia;
    } 



    public function isEnabled()
    {
       return $this->isActive;
    }


    /**
     * Get the value of enviosFN
     */ 
    public function getEnviosFN()
    {
        return $this->enviosFN;
    }

    /**
     * Set the value of enviosFN
     *
     * @return  self
     */ 
    public function setEnviosFN($enviosFN)
    {
        $this->enviosFN = $enviosFN;

        return $this;
    }
}