<?php
namespace App\Service;

use App\Entity\DaysObservers;
use App\Entity\ObservingDay;
use App\Entity\Observer;
use App\Repository\DaysObserversRepository;
use App\Repository\ObservingDayRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Security;


class DayService
{
    /** @var ObservingDayRepository */
    private $dayRepository;
    /** @var DaysObserversRepository */
    private $daysObserversRepository;
    private $entityManager;
    private $security;
    /** @var Observer */
    private $observer;

    public function __construct(
        EntityManagerInterface $entityManager,
        Security $security
    ) {
        $this->dayRepository = $entityManager->getRepository(ObservingDay::class);
        $this->daysObserversRepository = $entityManager->getRepository(DaysObservers::class);
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->observer = $this->security->getUser();
    }

    public function createDay(FormInterface $form) {
        $day = new ObservingDay();
        $day->setDate(new \DateTime());
        $day->setDayDescription($form->get("day_description")->getData());

        $daysObs = new DaysObservers();
        

        $this->entityManager->persist($day);
        $this->entityManager->flush();

        /** @var Observer */
        $user = $this->security->getUser();

        $daysObs->setObservingDayId($day->getId());
        $daysObs->setObserverId($user->getId());

        $this->entityManager->persist($daysObs);
        $this->entityManager->flush();

        return $day;
    }

    public function updateDayDescription(FormInterface $form, ObservingDay $day) 
    {
        $day->setDayDescription($form->get("day_description")->getData());

        $this->entityManager->persist($day);
        $this->entityManager->flush();

        return $day;
    }

    public function getObserversDays(): ?array {

        $days =  $this->dayRepository->findObserversDays($this->observer->getId());
        
        return $days;
    }

    public function deleteDay($day)
    {
        $this->dayRepository->deleteDay($day->getId());
    }

    public function getDayById($id): ObservingDay
    {
        return $this->dayRepository->findById($id);
    }
}