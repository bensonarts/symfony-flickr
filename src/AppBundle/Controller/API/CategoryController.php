<?php

namespace AppBundle\Controller\API;

use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends FOSRestController implements ClassResourceInterface
{
    /**
     * Get categories
     *
     * @View()
     *
     * @param Request $request
     * @return Response
     */
    public function cgetAction(Request $request)
    {
        return $this->getDoctrine()->getManager()->getRepository('AppBundle:Category')->findAll();
    }
}
