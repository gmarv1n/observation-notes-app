<?php
namespace App\Service;

use App\Entity\Observer;
use App\Entity\ObservingDay;
use App\Entity\DaysObjects;
use App\Entity\ObservingObject;
use App\Repository\DaysObserversRepository;
use App\Repository\DaysObjectsRepository;
use App\Repository\ObservingObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class DaysObjectsService
{
    /**
     * @var ObservingObjectRepository
     */
    private $objectRepository;

    private $daysRepository;

    /**
     * @var DaysObserversRepository
     */
    private $daysObserversRepository;

    /**
     * @var DaysObjectsRepository
     */
    private $daysObjectsRepository;

    /**
     * @var Security
     */
    private $security;

    /**
     * @var Observer
     */
    private $user;

    public function __construct(EntityManagerInterface $entityManager, Security $security) {
        $this->objectRepository = $entityManager->getRepository(ObservingObject::class);
        $this->daysRepository = $entityManager->getRepository(ObservingDay::class);
        $this->daysObjectsRepository = $entityManager->getRepository(DaysObjects::class);
        $this->security = $security;
        $this->user = $security->getUser();
    }

    public function getObjectToDayRelation($object): DaysObjects
    {
        $objectId = $object->getId();
        $objectRelation = $this->daysObjectsRepository->findRelationByObjectId($objectId);

        return $objectRelation;
    }


    public function deleteRealtionByObjectId($object) 
    {
        $this->daysObjectsRepository->deleteRelationByObjectId($object->getId());
    }
}