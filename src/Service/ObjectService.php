<?php
namespace App\Service;

use App\Entity\ObservingObject;
use App\Entity\DaysObjects;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormInterface;

class ObjectService
{
    /**
     * @var ObservingObjectRepository
     */
    private $objectRepository;

    private $daysObjectsRepository;
    private $entityManager;

    /**
     * @var Security
     */
    private $security;

    /**
     * @var Observer
     */
    private $user;

    public function __construct(
        EntityManagerInterface $entityManager,
        Security $security
    ) {
        $this->objectRepository = $entityManager->getRepository(ObservingObject::class);
        $this->daysObjectsRepository = $entityManager->getRepository(DaysObjects::class);
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->user = $security->getUser();
    }

    public function createObject(FormInterface $form, $day) 
    {
        $object = new ObservingObject();
        $object->setObjectName($form->get("object_name")->getData());
        $object->setObjectDescription($form->get("object_description")->getData());

        $this->entityManager->persist($object);
        $this->entityManager->flush();

        /** @var Observer */
        $user = $this->security->getUser();

        $dayObj = new DaysObjects();

        $dayObj->setObservingDayId($day->getId());
        $dayObj->setObservingObjectId($object->getId());

        $this->entityManager->persist($dayObj);
        $this->entityManager->flush();

        return $object;
    }

    public function updateObject(FormInterface $form, $object) 
    {
        $object->setObjectName($form->get("object_name")->getData());
        $object->setObjectDescription($form->get("object_description")->getData());

        $this->entityManager->persist($object);
        $this->entityManager->flush();

        return $object;
    }

    public function getAllObjects(): ?array 
    {
        return $this->objectRepository->findObserversObjects($this->user->getId());
    }

    public function getAllObjectsByDay($day): ?array 
    {
        return $this->objectRepository->findObjectsByDay($this->user->getId(), $day->getId());
    }

    public function deleteObject($object)
    {
        $this->objectRepository->deleteObject($object->getId());
    }
}