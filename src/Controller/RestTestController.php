<?php
namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\Post;

class RestTestController extends AbstractFOSRestController
{
    /**
     * @Post("/api/test", name="test")
     */
    public function test(Request $request): Response
    {
        $data = $request->request->get("test");

        return $this->json($data, 200);
    }
}