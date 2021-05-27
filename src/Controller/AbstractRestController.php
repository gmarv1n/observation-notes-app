<?php
namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Form\FormInterface;

abstract class AbstractRestController extends AbstractFOSRestController
{
    protected function buildRestForm(string $type, $data = null, array $options = []): FormInterface
    {
        $options = array_merge($options, [
            "csrf_protection" => false
            ]);
        $form = $this->container->get('form.factory')->createNamed("", $type, $data, $options);

        return $form;
    }
}