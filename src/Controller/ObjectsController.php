<?php
namespace App\Controller;

use App\Controller\AbstractRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api/object")
 */

class ObjectsController extends AbstractRestController
{
    /**
     * @Rest\Post("", name="addobject")
     */
    public function addObject(Request $request): Response {

        $view = $this->view("Adding object...", 200);

        return $this->handleView($view);
    }

    /**
     * @Rest\Get("", name="showobjects")
     */
    public function showbjects(Request $request): Response {

        $view = $this->view("Showing objects...", 200);

        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/{id}", name="showobject")
     */
    public function showbject(Request $request, $id): Response {

        $view = $this->view("Get object...".$id, 200);

        return $this->handleView($view);
    }

    /**
     * @Rest\Put("/{id}", name="editobject")
     */
    public function editbject(Request $request, $id): Response {

        $view = $this->view("Editing object...".$id, 200);

        return $this->handleView($view);
    }
}