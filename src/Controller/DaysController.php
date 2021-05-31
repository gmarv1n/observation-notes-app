<?php
namespace App\Controller;

use App\Controller\AbstractRestController;
use App\Form\ObservingDayType;
use App\Service\DayService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\ObservingDay;
use App\Repository\ObservingDayRepository;
use App\Service\DaysObserversService;
use Symfony\Component\Form\FormInterface;

/**
 * @Route("/api/day")
 */

class DaysController extends AbstractRestController
{

    private $dayService;
    private $daysObsService;

    public function __construct(DayService $dayService, DaysObserversService $daysObsService)
    {
        $this->dayService = $dayService;
        $this->daysObsService = $daysObsService;
    }

    /**
     * @Rest\Put("/{id}", name="editday")
     */
    public function editDay(Request $request, $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        /** @var ObservingDayRepository */
        $rep = $entityManager->getRepository(ObservingDay::class);
        $day = $rep->findById($id);

        if ($day == null) {
            $view = $this->view("No such day", 200);
            return $this->handleView($view);
            exit;
        }

        if ($this->daysObsService->checkDayToObserverRelation($day)) {
            $form = $this->buildDayForm($request, ['method' => 'PUT']);
            $this->validateForm($form);
            $day = $this->dayService->updateDayDescription($form, $day);

            $view = $this->view($day, 200);
            return $this->handleView($view);
        }

        $view = $this->view("You don't have a observe day with that ID", 200);
        return $this->handleView($view);
    }

    /**
     * @Rest\Post("", name="addday")
     */
    public function addDay(Request $request): Response {

        $form = $this->buildDayForm($request);

        $this->validateForm($form);

        $day = $this->dayService->createDay($form);

        $view = $this->view($day, 200);
        return $this->handleView($view);

    }

    /**
     * @Rest\Get("", name="showdays")
     */
    public function showDays(Request $request): Response 
    {
        $days = $this->dayService->getObserversDays();

        $view = $this->view($days, 200);

        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/{id}", name="showday")
     */
    public function showDay($id): Response 
    {
        $entityManager = $this->getDoctrine()->getManager();
        /** @var ObservingDayRepository */
        $rep = $entityManager->getRepository(ObservingDay::class);
        $day = $rep->findById($id);

        if ($day != null) {
            if ($this->daysObsService->checkDayToObserverRelation($day)) {
                $view = $this->view($day, 200);
                return $this->handleView($view);
            }
        }

        $message = "";
        if ($day != null) {
            $message = sprintf("You didn't made any ebservations on the day with ID %s", $day->getId());
        } else {
            $message = "There is no such day";
        }

        $view = $this->view($message, 200);

        return $this->handleView($view);
    }

    /**
     * @Rest\Delete("/{id}", name="deleteday")
     */
    public function deleteDay($id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        /** @var ObservingDayRepository */
        $rep = $entityManager->getRepository(ObservingDay::class);
        $day = $rep->findById($id);

        if ($day == null) {
            $view = $this->view("No such day", 200);
            return $this->handleView($view);
            exit;
        }

        if ($this->daysObsService->checkDayToObserverRelation($day)) {
            $this->dayService->deleteDay($day);
            $this->daysObsService->deleteRealtion($day);

            $view = $this->view(sprintf("Day with ID %s deleted", $id), 200);
            return $this->handleView($view);
        }

        $view = $this->view("You don't have an observing day with that ID", 200);
        return $this->handleView($view);
    }

    
    private function buildDayForm(Request $request, array $options = [])
    {
        $form = $this->buildRestForm(ObservingDayType::class, null, $options);
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