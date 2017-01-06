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
     * @View(serializerGroups={"list"})
     *
     * @param Request $request
     * @return Response
     */
    public function cgetAction(Request $request)
    {
        return $this->getDoctrine()->getManager()->getRepository('AppBundle:Category')->findAll();
    }

    /**
     * Get category by id. Show recursive objects.
     *
     * @View(serializerGroups={"detail"})
     *
     * @param Request $request
     * @return Response
     */
    public function getAction(Request $request, $id)
    {
        return $this->getDoctrine()->getManager()->getRepository('AppBundle:Category')->findOneById($id);
    }
}
