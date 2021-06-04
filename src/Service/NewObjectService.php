<?php
namespace App\Service;

use App\Entity\ObservingObject;
use App\Entity\DaysObjects;
use App\Entity\ObservingDay;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormInterface;
use App\Service\DayService;
use App\Service\DaysObjectsService;
use App\Service\DaysObserversService;

class NewObjectService
{
    /** @var ObservingObjectRepository */
    private $objectRepository;

    /** @var Security */
    private $security;

    /** @var Observer */
    private $user;

    /** @var DayService */
    private $dayService;

    /** @var DaysObjectsService */
    private $daysObjService;

    /** @var DaysObserversService */
    private $daysObsService;


    public function __construct(
        EntityManagerInterface $entityManager,
        DayService $dayService,
        DaysObjectsService $daysObjService,
        DaysObserversService $daysObsService,
        Security $security
    ) {
        $this->objectRepository = $entityManager->getRepository(ObservingObject::class);
        $this->daysObjectsRepository = $entityManager->getRepository(DaysObjects::class);
        $this->dayService = $dayService;
        $this->daysObjService = $daysObjService;
        $this->daysObsService = $daysObsService;
        $this->user = $security->getUser();
    }

    private function getObjectById($id): ?ObservingObject 
    {
        $object = $this->objectRepository->findById($id);
        return $object;
    }

    private function isObject($object): bool
    {
        if ($object !== null) { return true; }
        return false;
    }

    private function getRelation(ObservingObject $object): DaysObjects
    {
        return $this->daysObjService->getObjectToDayRelation($object);
    }

    private function getObservingDay(DaysObjects $relation): ObservingDay
    {
        return $this->dayService->getDayById($relation->getObservingDayId());
    }

    public function getObjectorNull($id): ?ObservingObject
    {
        $object = $this->getObjectById($id);
        if ($this->isObject($object) === false) {
            return null;
        }
        $relation = $this->getRelation($object);
        $day = $this->getObservingDay($relation);
        if ($this->daysObsService->checkDayToObserverRelation($day)) {
            return $object;
        }

        return null;
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