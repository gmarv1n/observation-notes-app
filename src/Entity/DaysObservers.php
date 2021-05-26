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
     */
    private $observer_id;

    /**
     * @ORM\Column(type="integer", nullable=false)
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

    public function getObservingDyaId()//: ?string
    {
        return $this->observer_id;
    }

    public function setObservingDyaId($observing_day_id): self
    {
        $this->observing_day_id = $observing_day_id;

        return $this;
    }

  
}
