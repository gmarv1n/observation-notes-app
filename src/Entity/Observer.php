<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ObserverRepository")
 * @Table(name="observer")
 * @UniqueEntity(fields={"observer_name"}, message="Observer with this name already exists")
 */

class Observer implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true, nullable=false)
     */
    private $observer_name;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    public function getId()
    {
        return $this->id;
    }

    public function setUsername(string $name): self
    {
        $this->observer_name = $name;
        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->observer_name;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(): self
    {
        $this->roles = ["ROLE_OBSERVER"];

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
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
}