<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\DaysObjects;
use App\Repository\ObservingObjectFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Repository\ObservingObjectRepository;
use App\Repository\ObservingDayRepository;

class DaysObjectsFixtures extends Fixture implements DependentFixtureInterface
{
    private $observingDayRepository;
    private $observingObjectRepository;

    public function __construct(ObservingDayRepository $observingDayRepository, ObservingObjectRepository $observingObjectRepository)
    {
        $this->observingDayRepository = $observingDayRepository;
        $this->observingObjectRepository = $observingObjectRepository;
    }


    public function load(ObjectManager $manager)
    {
        $days = $this->observingDayRepository->findAll();
        $objects = $this->observingObjectRepository->findAll();

        // d0 ob0
        $dayObj1 = new DaysObjects();
        $dayObj1->setObservingDayId($days[0]->getId());
        $dayObj1->setObservingObjectId($objects[0]->getId());

        // d0 ob1
        $dayObj2 = new DaysObjects();
        $dayObj2->setObservingDayId($days[0]->getId());
        $dayObj2->setObservingObjectId($objects[1]->getId());

        // d1 ob2
        $dayObj3 = new DaysObjects();
        $dayObj3->setObservingDayId($days[1]->getId());
        $dayObj3->setObservingObjectId($objects[2]->getId());

        // d2 ob3
        $dayObj4 = new DaysObjects();
        $dayObj4->setObservingDayId($days[2]->getId());
        $dayObj4->setObservingObjectId($objects[3]->getId());

        // d2 ob4
        $dayObj5 = new DaysObjects();
        $dayObj5->setObservingDayId($days[2]->getId());
        $dayObj5->setObservingObjectId($objects[4]->getId());

        $manager->persist($dayObj1);
        $manager->persist($dayObj2);
        $manager->persist($dayObj3);
        $manager->persist($dayObj4);
        $manager->persist($dayObj5);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ObservingObjectFixtures::class,
        ];
    }
}