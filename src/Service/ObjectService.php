<?php
namespace App\Service;

use App\Entity\DaysObservers;
use App\Entity\ObservingDay;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class ObjectService
{
    private $objectRepository;
    private $daysObjectsRepository;
    private $security;

    public function __construct(
        EntityManagerInterface $entityManager,
        Security $security
    ) {
        $this->objectRepository = $entityManager->getRepository(ObservingObject::class);
        $this->daysObjectsRepository = $entityManager->getRepository(DaysObjects::class);
        $this->security = $security;
    }
}