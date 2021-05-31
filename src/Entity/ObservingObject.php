<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ObservingObjectRepository")
 * @Table(name="observing_object")
 */
class ObservingObject
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $object_name;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    private $object_description;

    public function getId()
    {
        return $this->id;
    }

    public function getObjectName(): ?String
    {
        return $this->object_name;
    }

    public function setObjectName(string $object_name): self
    {
        $this->object_name = $object_name;
        return $this;
    }

    public function getObjectDescription(): ?String
    {
        return $this->object_description;
    }

    public function setObjectDescription(string $object_description): self
    {
        $this->object_description = $object_description;
        return $this;
    }
}