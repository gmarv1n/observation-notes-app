<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\ObservingDayFixtures;
use App\Entity\ObservingObject;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Repository\ObservingDayRepository;

class ObservingObjectFixtures extends Fixture implements DependentFixtureInterface
{
    private $observingDayRepository;

    public function __construct(ObservingDayRepository $observingDayRepository)
    {
        $this->observingDayRepository = $observingDayRepository;
    }

    public function load(ObjectManager $manager)
    {
        $observingDays = $this->observingDayRepository->findAll();

        $mars = new ObservingObject();
        $mars->setObjectName("Mars");
        $mars->setObjectDescription("The Mars didn't shown anything."); // d0 ob0

        $jupiter = new ObservingObject();
        $jupiter->setObjectName("Jupiter");
        $jupiter->setObjectDescription("Jupiter was awesome."); // d0 ob1

        $orion = new ObservingObject();
        $orion->setObjectName("Orion nebula");
        $orion->setObjectDescription("It was greyscale, but with huge amount of details."); // d1 ob2

        $california = new ObservingObject();
        $california->setObjectName("California nebula");
        $california->setObjectDescription("It wasn't able to see anything because of light pollution."); // d2 ob3

        $moon = new ObservingObject();
        $moon->setObjectName("Moon");
        $moon->setObjectDescription("The only object seen on the sky."); // d2 ob4

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