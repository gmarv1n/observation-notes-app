<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Observer;

class ObserverFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        // $manager->flush();

        $observerIvan = new Observer();
        $observerIvan->setObserverName("Ivan");
        $observerIvan->setPassword("secret");

        $observerJohn = new Observer();
        $observerJohn->setObserverName("John");
        $observerJohn->setPassword("secret");

        $manager->persist($observerIvan);
        $manager->persist($observerJohn);
        $manager->flush();

    }
}
