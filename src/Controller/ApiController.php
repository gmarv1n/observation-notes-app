<?php
namespace App\Controller;

use App\Repository\ObserverRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ObservingDayRepository;

class ApiController extends AbstractController
{
    /**
     * @Route("/auth/signin", name="signin", methods={"POST"})
     */
    public function signIn(Request $request): Response
    {
        $user = $this->getUser();
        
        return $this->json($user, 200);
    }

    /**
     * @Route("/logout", name="logout", methods={"GET"})
     */
    public function logout(Request $request): Response
    {
        return $this->json(["Message" => "Logged out"], 200);
    }

    /**
     * @Route("/days", name="days", methods={"GET"})
     */
    public function showDays(Request $request, ObservingDayRepository $repo): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $days = $repo->findAll();
        return $this->json($days, 200);
    }

}