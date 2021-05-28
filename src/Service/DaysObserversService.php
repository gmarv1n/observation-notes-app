<?php
namespace App\Service;

use App\Entity\Observer;
use App\Entity\ObservingDay;
use App\Entity\DaysObservers;
use App\Repository\DaysObserversRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class DaysObserversService
{
    private $observerRepository;

    private $daysRepository;

    /**
     * @var DaysObserversRepository
     */
    private $daysObserversRepository;

    /**
     * @var Security
     */
    private $security;

    /**
     * @var Observer
     */
    private $user;

    public function __construct(
        EntityManagerInterface $entityManager,
        Security $security
    ) {
        $this->observerRepository = $entityManager->getRepository(Observer::class);
        $this->daysRepository = $entityManager->getRepository(ObservingDay::class);
        $this->daysObserversRepository = $entityManager->getRepository(DaysObservers::class);
        $this->security = $security;
        $this->user = $security->getUser();
    }

    public function checkDayToObserverRelation($day): bool {
        $dayId = $day->getId();
        $dayRelation = $this->daysObserversRepository->findByDayId($dayId);

        if ($this->user->getId() != $dayRelation->getObserverId()) {
            return false;
        }

        return true;
    }
}