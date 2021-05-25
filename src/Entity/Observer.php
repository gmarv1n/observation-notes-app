<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ObserverRepository")
 * @Table(name="observer")
 */
class Observer
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
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    public function getId()
    {
        return $this->id;
    }

    public function setObserverName(string $name): self
    {
        $this->observer_name = $name;
        return $this;
    }

    public function getObserverName(): ?string
    {
        return $this->observer_name;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }
}