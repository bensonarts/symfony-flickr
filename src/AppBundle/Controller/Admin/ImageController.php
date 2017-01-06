<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Category;
use AppBundle\Entity\Image;
use AppBundle\Form\CategoryType;
use AppBundle\Form\ImageType;
use AppBundle\Form\DeleteType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ImageController extends Controller
{
    /**
     * Display list of images by category
     *
     * @param Request $request
     * @param Category $categore
     * @param Response
     *
     * @Route("/admin/category/{id}/image", name="admin_image_index")
     */
    public function indexAction(Request $request, Category $category)
    {
        if (!$category) {
            throw $this->createNotFoundException();
        }

        return $this->render('default/admin/image/index.html.twig', [
            'category' => $category,
        ]);
    }

    /**
     * Create new image
     *
     * @param Request $request
     * @param Response
     *
     * @Route("/admin/category/{id}/image/create", name="admin_image_create")
     */
    public function createAction(Request $request, Category $category)
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->getData();

            $flickrManager = $this->get('flickr.manager');
            $callback = $this->generateUrl('admin_image_create',
                ['id' => $category->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

            $result = $flickrManager->upload($image->getUrl(), $image->getTitle(), $callback);

            $flickrUrl = $result->sizes->urls->url;
            // Get image sizes collection.
            foreach ($result->sizes->size as $size) {
                switch ($size['label']) {
                    case 'Thumbnail':
                        $image->setThumbnailUrl($size['source']);
                        break;
                    case 'Medium':
                        $image->setUrl($size['source']);
                        break;
                    default:
                        break;
                }
            }
            #print('<pre>' . print_r($result, true) . '</pre>');exit;

            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();

            return $this->redirectToRoute('admin_image_index', [ 'id' => $category->getId() ]);
        }

        return $this->render('default/admin/image/create.html.twig', [
            'form' => $form->createView(),
            'category' => $category
        ]);
    }

    /**
     * Edit image
     *
     * @param Request $request
     * @param Response
     *
     * @Route("/admin/image/edit/{id}", name="admin_image_edit")
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
     * @param Response
     *
     * @Route("/admin/image/delete/{id}", name="admin_image_delete")
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
