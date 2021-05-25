<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ObservingDayRepository")
 * @Table(name="observing_day")
 */
class ObservingDay
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
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    private $day_description;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function getDayDescription(): ?String
    {
        return $this->day_description;
    }

    public function setDayDescription(string $day_description): self
    {
        $this->day_description = $day_description;
        return $this;
    }
}
