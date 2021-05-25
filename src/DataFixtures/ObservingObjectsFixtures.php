<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\ObserversFixtures;
use App\Entity\ObservingDay;
use App\Entity\ObservingObject;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Repository\ObservingDayRepository;

class ObservingObjectsFixtures extends Fixture implements DependentFixtureInterface
{
    private $observingDayRepository;

    public function __construct(ObservingDayRepository $observingDayRepository)
    {
        $this->observingDayRepository = $observingDayRepository;
    }


    public function load(ObjectManager $manager)
    {
        $observingDays = $this->observingDayRepository->findAll();

        // $dayOne = new ObservingDay();
        // $dayOne->setObserverId($observers[0]->getId());
        // $dayOne->setDate(new \DateTime('2021-05-14'));
        // $dayOne->setDayDescription("It was a pretty goof day for astronomical observations.");

        // $dayTwo = new ObservingDay();
        // $dayTwo->setObserverId($observers[0]->getId());
        // $dayTwo->setDate(new \DateTime('2021-05-22'));
        // $dayTwo->setDayDescription("It was cold and way too windy to observe planets.");

        // $dayThree = new ObservingDay();
        // $dayThree->setObserverId($observers[1]->getId());
        // $dayThree->setDate(new \DateTime('2021-05-20'));
        // $dayThree->setDayDescription("It was cold and way too windy to observe planets.");
        $mars = new ObservingObject();
        $mars->setDayId($observingDays[0]->getId());
        $mars->setObjectName("Mars");
        $mars->setObjectDescription("The Mars didn't shown anything.");

        $jupiter = new ObservingObject();
        $jupiter->setDayId($observingDays[0]->getId());
        $jupiter->setObjectName("Jupiter");
        $jupiter->setObjectDescription("Jupiter was awesome.");

        $orion = new ObservingObject();
        $orion->setDayId($observingDays[1]->getId());
        $orion->setObjectName("Orion nebula");
        $orion->setObjectDescription("It was greyscale, but with huge amount of details.");

        $california = new ObservingObject();
        $california->setDayId($observingDays[2]->getId());
        $california->setObjectName("California nebula");
        $california->setObjectDescription("It wasn't able to see anything because of light pollution.");

        $moon = new ObservingObject();
        $moon->setDayId($observingDays[2]->getId());
        $moon->setObjectName("Moon");
        $moon->setObjectDescription("The only object seen on the sky.");

        $manager->persist($mars);
        $manager->persist($jupiter);
        $manager->persist($orion);
        $manager->persist($california);
        $manager->persist($moon);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ObservingDayFixtures::class,
        ];
    }
}