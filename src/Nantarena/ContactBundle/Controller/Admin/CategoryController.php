<?php

namespace Nantarena\ContactBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
// Manage routing
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
// Request for form
use Symfony\Component\HttpFoundation\Request;

// Entity
use Nantarena\ContactBundle\Entity\Category;
// Form type
use Nantarena\ContactBundle\Form\Type\CategoryType;

/**
 * Class CategoryController
 *
 * @package Nantarena\ContactBundle\Controller\Admin
 *
 * @Route("/admin/contact/category")
 */
class CategoryController extends Controller
{
    /**
     * @Route("/", name="nantarena_admin_contact_category_list")
     * @Template()
     */
    public function listAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository('NantarenaContactBundle:Category');
        $lcategory = $repository->findAll();

        return array('lcategory' => $lcategory);
    }

    /**
     * @Route("/create", name="nantarena_admin_contact_category_create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $category = new Category();
        $category->setName('');

        $form = $this->createForm(new CategoryType(), $category, array(
            'action' => $this->get('nantarena_contact.category_manager')->getCreatePath(),
            'method' => 'POST',
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            try {
                // add the new category
                $em = $this->getDoctrine()->getManager();
                $em->persist($category);

                // commit changes in database
                $em->flush();

                // messages
                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('contact.admin.category.create.flash_success'));
            } catch (\Exception $e) {
                $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('contact.admin.category.create.flash_error'));
            }

            return $this->redirect($this->generateUrl('nantarena_admin_contact_category_list'));
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/edit/{id}", name="nantarena_admin_contact_category_edit")
     * @Template()
     */
    public function editAction(Request $request, Category $category)
    {
        $form = $this->createForm(new CategoryType(), $category, array(
            'action' => $this->get('nantarena_contact.category_manager')->getEditPath($category),
            'method' => 'POST',
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('contact.admin.category.edit.flash_success'));
            } catch (\Exception $e) {
                $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('contact.admin.category.edit.flash_error'));
            }

            return $this->redirect($this->generateUrl('nantarena_admin_contact_category_list'));
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/delete/{id}", name="nantarena_admin_contact_category_delete")
     * @Template()
     */
    public function deleteAction(Request $request, Category $category)
    {
        $form = $this->createDeleteForm($category->getId());

        $form->handleRequest($request);

        if ($form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->remove($category);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('contact.admin.category.delete.flash_success'));
            } catch (\Exception $e) {
                $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('contact.admin.category.delete.flash_error'));
            }

            return $this->redirect($this->generateUrl('nantarena_admin_contact_category_list'));
        }

        return array(
            'form' => $form->createView(),
            'category' => $category,
        );
    }

    /**
     * Creates a form to delete a Header news entity by id.
     *
     * @param integer $id
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->add('submit', 'submit')
            ->setMethod('POST')
            ->setAction($this->generateUrl('nantarena_admin_contact_category_delete', array(
                'id' => $id
            )))
            ->getForm();
    }
}