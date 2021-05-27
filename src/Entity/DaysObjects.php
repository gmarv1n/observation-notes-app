<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DaysObjectsRepository")
 * @Table(name="days_objects")
 */
class DaysObjects
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\OneToMany(targetEntity="ObservingDay", mappedBy="id")
     */
    private $observing_day_id;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\OneToMany(targetEntity="ObservingObject", mappedBy="id")
     */
    private $observing_object_id;

    public function getId()
    {
        return $this->id;
    }

    public function getObservingObjectId()//: ?string
    {
        return $this->observing_object_id;
    }

    public function setObservingObjectId($observing_object_id): self
    {
        $this->observing_object_id = $observing_object_id;

        return $this;
    }

    public function getObservingDayId()//: ?string
    {
        return $this->observing_day_id;
    }

    public function setObservingDayId($observing_day_id): self
    {
        $this->observing_day_id = $observing_day_id;

        return $this;
    }

  
}
