<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ObservingDayRepository;

class ApiController extends AbstractController
{

    /**
     * @Route("/days", name="days", methods={"GET"})
     */
    public function showDays(Request $request, ObservingDayRepository $repository): Response
    {

        $firstDay = $repository->findAll()[0];
        $result = get_object_vars($firstDay);
        return $this->json($firstDay, 200);
    }
}