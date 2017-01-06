<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Category;
use AppBundle\Form\CategoryType;
use AppBundle\Form\DeleteType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin/category")
 */
class CategoryController extends Controller
{
    /**
     * Display list of categories
     *
     * @param Request $request
     * @param Response
     *
     * @Route("/", name="admin_category_index")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('AppBundle:Category')->findAll();

        return $this->render('default/admin/category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * Create new category
     *
     * @param Request $request
     * @param Response
     *
     * @Route("/create", name="admin_category_create")
     */
    public function createAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('admin_category_index');
        }

        return $this->render('default/admin/category/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Edit category
     *
     * @param Request $request
     * @param Category $categore
     * @param Response
     *
     * @Route("/edit/{id}", name="admin_category_edit")
     */
    public function editAction(Request $request, Category $category)
    {
        if (!$category) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('admin_category_index');
        }

        return $this->render('default/admin/category/create.html.twig', [
            'form' => $form->createView(),
            'category' => $category
        ]);
    }

    /**
     * Delete category
     *
     * @param Request $request
     * @param Category $categore
     * @param Response
     *
     * @Route("/delete/{id}", name="admin_category_delete")
     */
    public function deleteAction(Request $request, Category $category)
    {
        if (!$category) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(DeleteType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //
        }

        return $this->render('default/admin/category/delete.html.twig', [
            'form' => $form->createView(),
            'category' => $category
        ]);
    }
}
