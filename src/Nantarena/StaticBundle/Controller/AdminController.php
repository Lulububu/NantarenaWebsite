<?php

namespace Nantarena\StaticBundle\Controller;

use Doctrine\ORM\ORMException;
use Nantarena\AdminBundle\Controller\DashboardInterface;
use Nantarena\StaticBundle\Entity\StaticContent;
use Nantarena\StaticBundle\Form\Type\StaticContentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AdminController
 *
 * @package Nantarena\StaticBundle\Controller
 *
 * @Route("/admin/static")
 */
class AdminController extends Controller implements DashboardInterface
{
    /**
     * @Route("/", name="nantarena_static_admin_index")
     * @Template()
     */
    public function indexAction()
    {
        return array(
            'contents' => $this->getDoctrine()->getRepository('NantarenaStaticBundle:StaticContent')->findAll(),
        );
    }

    /**
     * @Route("/edit/{id}", name="nantarena_static_admin_edit")
     * @Template()
     */
    public function editAction(Request $request, StaticContent $content)
    {
        $form = $this->createForm(new StaticContentType(), $content, array(
            'action' => $this->get('nantarena_static.static_content_manager')->getEditPath($content),
            'method' => 'POST',
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();

                $em->persist($content);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('static.admin.static_content.edit.flash_success', array(
                    '%title%' => $content->getTitle(),
                )));

                return $this->redirect($this->get('nantarena_static.static_content_manager')->getEditPath($content));
            } catch (\Exception $e) {
                $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('static.admin.static_content.edit.flash_error', array(
                    '%title%' => $content->getTitle(),
                )));
            }
        }

        return array(
            'content' => $content,
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/delete/{id}", name="nantarena_static_admin_delete")
     * @Template()
     */
    public function deleteAction(Request $request, StaticContent $content)
    {
        $form = $this->createDeleteForm($content->getId())->handleRequest($request);

        if ($form->isValid()) {
            if ($form->get('id')->getData() == $content->getId()) {
                $em = $this->getDoctrine()->getManager();

                $em->remove($content);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('static.admin.static_content.delete.flash_success', array(
                    '%title%' => $content->getTitle(),
                )));
            } else {
                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('static.admin.static_content.delete.flash_error'));
            }

            return $this->redirect($this->generateUrl('nantarena_static_admin_index'));
        }

        return array(
            'form' => $form->createView(),
            'content' => $content,
        );
    }

    /**
     * @Route("/create", name="nantarena_static_admin_create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $content = new StaticContent();
        $form = $this->createForm(new StaticContentType(), $content, array(
            'action' => $this->get('nantarena_static.static_content_manager')->getCreatePath(),
            'method' => 'POST',
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();

                $em->persist($content);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('static.admin.static_content.create.flash_success', array(
                    '%title%' => $content->getTitle(),
                )));

                return $this->redirect($this->generateUrl('nantarena_static_admin_index'));
            } catch (ORMException $e) {
                $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('static.admin.static_content.create.flash_error', array(
                    '%title%' => $content->getTitle(),
                )));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @param integer $id
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->add('submit', 'submit')
            ->setMethod('POST')
            ->setAction($this->generateUrl('nantarena_static_admin_delete', array(
                'id' => $id
            )))
            ->getForm();
    }

    public function dashboardAction()
    {
        $translator = $this->get('translator');

        return array(
            'module_title' => $translator->trans('static.admin.dashboard.title'),
            'module_links' => array(
                $translator->trans('static.admin.dashboard.static_create') => array(
                    'url' => $this->generateUrl('nantarena_static_admin_create'),
                    'role' => 'ROLE_STATIC_ADMIN'
                ),
                $translator->trans('static.admin.dashboard.static_management') => array(
                    'url' => $this->generateUrl('nantarena_static_admin_index'),
                    'role' => 'ROLE_STATIC_ADMIN'
                ),
            )
        );
    }
}
