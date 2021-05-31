<?php
namespace App\Controller;

use App\Controller\AbstractRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\ObservingObject;
use App\Entity\ObservingDay;
use App\Service\ObjectService;
use App\Service\DaysObjectsService;
use App\Service\DaysObserversService;
use App\Form\ObservingObjectType;


/**
 * @Route("/api/object")
 */

class ObjectsController extends AbstractRestController
{

    private $objectService;
    private $daysObjService;
    private $daysObsService;

    public function __construct(ObjectService $objService, DaysObjectsService $daysObjService, DaysObserversService $daysObsService)
    {
        $this->objectService = $objService;
        $this->daysObjService = $daysObjService;
        $this->daysObsService = $daysObsService;
    }

    /**
     * @Rest\Get("/{id}", name="showobject")
     */
    public function showbject($id): Response 
    {
        $entityManager = $this->getDoctrine()->getManager();
        /** @var ObservingObjectRepository */
        $objectRep = $entityManager->getRepository(ObservingObject::class);
        $object = $objectRep->findById($id);

        if ($object == null) {
            $view = $this->view("No such object", 200);
            return $this->handleView($view);
            exit;
        }
        $dayObj = $this->daysObjService->getObjectToDayRelation($object);

        /** @var ObservingDayRepository */
        $dayRep = $entityManager->getRepository(ObservingDay::class);
        $day = $dayRep->findById($dayObj->getObservingDayId());

        if ($this->daysObsService->checkDayToObserverRelation($day)) {
            $view = $this->view($object, 200);
            return $this->handleView($view);
        }

        $view = $this->view(sprintf("Object with ID %s is not your object", $id), 200);
        return $this->handleView($view);
    }

    /**
     * @Rest\Post("/day/{dayId}", name="addobject")
     */
    public function addObject(Request $request, $dayId): Response 
    {
        $entityManager = $this->getDoctrine()->getManager();
        /** @var ObservingDayRepository */
        $rep = $entityManager->getRepository(ObservingDay::class);
        $day = $rep->findById($dayId);

        if ($day == null) {
            $view = $this->view("No such day", 200);
            return $this->handleView($view);
            exit;
        }

        if ($this->daysObsService->checkDayToObserverRelation($day)) {
            $form = $this->buildObjectForm($request);
            $this->validateForm($form);

            $object = $this->objService->createObject($form, $day);

            $view = $this->view($object, 200);

            return $this->handleView($view);
        }

        $view = $this->view(sprintf("You have no observation days with ID %s", $dayId), 200);

        return $this->handleView($view);
    }

    /**
     * @Rest\Get("", name="showobjects")
     */
    public function showObjects(): Response 
    {
        $objects = $this->objectService->getAllObjects();

        $view = $this->view($objects, 200);

        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/day/{dayId}", name="showobjectsbyday")
     */
    public function showObjectsByDay($dayId): Response 
    {
        $entityManager = $this->getDoctrine()->getManager();
        /** @var ObservingDayRepository */
        $rep = $entityManager->getRepository(ObservingDay::class);
        $day = $rep->findById($dayId);

        if ($day == null) {
            $view = $this->view("No such day", 200);
            return $this->handleView($view);
            exit;
        }

        if ($this->daysObsService->checkDayToObserverRelation($day)) {
            $objects = $this->objectService->getAllObjectsByDay($day);

            $view = $this->view($objects, 200);
            return $this->handleView($view);
        }


        $view = $this->view(sprintf("You have no observation days with ID %s", $dayId), 200);
        return $this->handleView($view);
    }

    

    /**
     * @Rest\Put("/{id}", name="editobject")
     */
    public function editbject(Request $request, $id): Response 
    {
        $entityManager = $this->getDoctrine()->getManager();
        /** @var ObservingObjectRepository */
        $objectRep = $entityManager->getRepository(ObservingObject::class);
        $object = $objectRep->findById($id);

        if ($object == null) {
            $view = $this->view("No such object", 200);
            return $this->handleView($view);
            exit;
        }

        $dayObj = $this->daysObjService->getObjectToDayRelation($object);

        /** @var ObservingDayRepository */
        $dayRep = $entityManager->getRepository(ObservingDay::class);
        $day = $dayRep->findById($dayObj->getObservingDayId());

        if ($this->daysObsService->checkDayToObserverRelation($day)) {
            $form = $this->buildObjectForm($request, ['method' => 'PUT']);
            $this->validateForm($form);

            $object = $this->objService->updateObject($form, $object);

            $view = $this->view($object, 200);

            return $this->handleView($view);
        }

        
        $view = $this->view(sprintf("You have no observation days with ID %s", $id), 200);

        return $this->handleView($view);
    }

    /**
     * @Rest\Delete("/{id}", name="deleteobject")
     */
    public function deleteDay($id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        /** @var ObservingObjectRepository */
        $objectRep = $entityManager->getRepository(ObservingObject::class);
        $object = $objectRep->findById($id);

        if ($object == null) {
            $view = $this->view("No such object", 200);
            return $this->handleView($view);
            exit;
        }

        $dayObj = $this->daysObjService->getObjectToDayRelation($object);

        /** @var ObservingDayRepository */
        $dayRep = $entityManager->getRepository(ObservingDay::class);
        $day = $dayRep->findById($dayObj->getObservingDayId());

        if ($this->daysObsService->checkDayToObserverRelation($day)) {
            $this->objectService->deleteObject($object);
            $this->daysObjService->deleteRealtionByObjectId($object);

            $view = $this->view(sprintf("Object with ID %s deleted", $id), 200);

            return $this->handleView($view);
        }

        
        $view = $this->view(sprintf("Observing object with ID %s is not yours", $id), 200);

        return $this->handleView($view);
    }

    private function buildObjectForm(Request $request, array $options = [])
    {
        $form = $this->buildRestForm(ObservingObjectType::class, null, $options);
        $form->handleRequest($request);

        return $form;
    }

    private function validateForm($form)
    {
        if (!$form->isSubmitted()) {
            print "Not submitted";
            return $this->handleView($this->view($form, 200));
            exit;
        }
        if (!$form->isValid()) {
            print "Not valid";
            return $this->handleView($this->view($form, 200));
            exit;
        }
    }
}