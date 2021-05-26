<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Observer;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ObserverFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->passwordEncoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        // $manager->flush();

        $observerIvan = new Observer();
        $observerIvan->setUsername("Ivan");
        $observerIvan->setRoles();
        $observerIvan->setPassword($this->passwordEncoder->encodePassword($observerIvan, "secret"));

        $observerJohn = new Observer();
        $observerJohn->setUsername("John");
        $observerJohn->setRoles();
        $observerJohn->setPassword($this->passwordEncoder->encodePassword($observerJohn, "secret"));

        $manager->persist($observerIvan);
        $manager->persist($observerJohn);
        $manager->flush();
    }
}
