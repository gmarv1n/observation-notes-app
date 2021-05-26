<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\ObservingDayFixtures;
use App\DataFixtures\ObserverFixtures;
use App\Entity\DaysObservers;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Repository\ObserverRepository;
use App\Repository\ObservingDayRepository;

class DaysObserversFixtures extends Fixture implements DependentFixtureInterface
{
    private $observingDayRepository;
    private $observerRepository;

    public function __construct(ObservingDayRepository $observingDayRepository, ObserverRepository $observerRepository)
    {
        $this->observingDayRepository = $observingDayRepository;
        $this->observerRepository = $observerRepository;
    }


    public function load(ObjectManager $manager)
    {
        $days = $this->observingDayRepository->findAll();
        $observers = $this->observerRepository->findAll();

        // o0 d0

        $dayObs1 = new DaysObservers();
        $dayObs1->setObserverId($observers[0]->getId());
        $dayObs1->setObservingDyaId($days[0]->getId());

        // o0 d1
        $dayObs2 = new DaysObservers();
        $dayObs2->setObserverId($observers[0]->getId());
        $dayObs2->setObservingDyaId($days[1]->getId());

        // o1 d2
        $dayObs3 = new DaysObservers();
        $dayObs3->setObserverId($observers[1]->getId());
        $dayObs3->setObservingDyaId($days[2]->getId());

        $manager->persist($dayObs1);
        $manager->persist($dayObs2);
        $manager->persist($dayObs3);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ObservingDayFixtures::class,
        ];
    }
}