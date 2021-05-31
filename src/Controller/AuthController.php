<?php
namespace App\Controller;

use App\Entity\Observer;
use App\Form\ObserverType;
use App\Controller\AbstractRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AuthController extends AbstractRestController
{
    /**
     * @Rest\Post("/api/test", name="test")
     */
    
    public function test(Request $request): Response
    {
        $data = $request->request->get("test");

        return $this->json($data, 200);
    }
    /**
     * @Route("/api/auth/signin", name="signin", methods={"POST"})
     */
    public function signIn(Request $request): Response
    {
        $user = $this->getUser();
        
        return $this->json($user, 200);
    }

    /**
     * @Route("/signout", name="logout")
     */
    public function signOut(Request $request): Response
    {
        return $this->json(["Message" => "Logged out"], 200);
    }

    /**
     * @Rest\Post("/api/auth/signup", name="signup")
     */
    public function signUp(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $observer = new Observer();
        $form = $this->buildRestForm(ObserverType::class);

        $form->handleRequest($request);

        if (!$form->isSubmitted()) {
            print "Not submitted";
            return $this->json($form, 200);
            exit;
        }
        if (!$form->isValid()) {
            print "Not valid";
            return $this->json($form, 200);
            exit;
        }

        $observer->setUsername($form->get('username')->getData());
        $observer->setPassword($passwordEncoder->encodePassword($observer,$form->get('password')->getData()));
        $observer->setRoles();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($observer);
        $entityManager->flush();
        
        // return $this->json($observer, 200);

        $view = $this->view($observer, 200);

        return $this->handleView($view);
    }
}