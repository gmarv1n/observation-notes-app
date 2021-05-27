<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\ObserverFixtures;
use App\Entity\ObservingDay;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Repository\ObserverRepository;

class ObservingDayFixtures extends Fixture implements DependentFixtureInterface
{
    private $observerRepository;

    public function __construct(ObserverRepository $observerRepository)
    {
        $this->observerRepository = $observerRepository;
    }


    public function load(ObjectManager $manager)
    {
        $observers = $this->observerRepository->findAll();

        $dayOne = new ObservingDay();
        $dayOne->setDate(new \DateTime('2021-05-14'));
        $dayOne->setDayDescription("It was a pretty goof day for astronomical observations.");  // o0 d0

        $dayTwo = new ObservingDay();
        $dayTwo->setDate(new \DateTime('2021-05-22'));
        $dayTwo->setDayDescription("It was cold and way too windy to observe planets."); // o0 d1

        $dayThree = new ObservingDay();
        $dayThree->setDate(new \DateTime('2021-05-20'));
        $dayThree->setDayDescription("It was cold and way too windy to observe planets."); // o1 d2

        $manager->persist($dayOne);
        $manager->persist($dayTwo);
        $manager->persist($dayThree);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ObserverFixtures::class,
        ];
    }
}