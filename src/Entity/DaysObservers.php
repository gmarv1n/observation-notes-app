<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DaysObserversRepository")
 * @Table(name="days_observers")
 */
class DaysObservers
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\OneToMany(targetEntity="Observer", mappedBy="id")
     */
    private $observer_id;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\OneToMany(targetEntity="ObservingDay", mappedBy="id")
     */
    private $observing_day_id;

    public function getId()
    {
        return $this->id;
    }

    public function getObserverId()//: ?string
    {
        return $this->observer_id;
    }

    public function setObserverId($observer_id): self
    {
        $this->observer_id = $observer_id;

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
