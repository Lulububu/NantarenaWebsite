<?php

namespace Nantarena\EventBundle\Controller\Admin;

use Nantarena\EventBundle\Entity\EntryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Nantarena\EventBundle\Form\Type\EntryTypeType;

/**
 * Class EntryTypesController
 *
 * @package Nantarena\EventBundle\Controller\Admin
 *
 * @Route("/admin/event/entrytypes")
 */
class EntryTypesController extends Controller
{
    /**
     * @Route("/", name="nantarena_event_admin_entrytypes")
     * @Template()
     */
    public function listAction()
    {
        return array(
            'types' => $this->getDoctrine()->getRepository('NantarenaEventBundle:EntryType')->findAll(),
        );
    }

    /**
     * @Route("/create", name="nantarena_event_admin_entrytypes_create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $type = new EntryType();

        $form = $this->createForm(new EntryTypeType(), $type, array(
            'action' => $this->generateUrl('nantarena_event_admin_entrytypes_create'),
            'method' => 'POST',
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $translator = $this->get('translator');
            $flashbag = $this->get('session')->getFlashBag();

            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($type);
                $em->flush();

                $flashbag->add('success', $translator->trans('event.admin.entrytypes.create.flash_success'));
                return $this->redirect($this->generateUrl('nantarena_event_admin_entrytypes'));

            } catch (\Exception $e) {
                $flashbag->add('error', $translator->trans('event.admin.entrytypes.create.flash_error'));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/edit/{id}", name="nantarena_event_admin_entrytypes_edit")
     * @Template()
     */
    public function editAction(Request $request, EntryType $type)
    {
        $form = $this->createForm(new EntryTypeType(), $type, array(
            'action' => $this->generateUrl('nantarena_event_admin_entrytypes_edit', array(
                'id' => $type->getId()
            )),
            'method' => 'POST',
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $translator = $this->get('translator');
            $flashbag = $this->get('session')->getFlashBag();

            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($type);
                $em->flush();

                $flashbag->add('success', $translator->trans('event.admin.entrytypes.edit.flash_success'));
                return $this->redirect($this->generateUrl('nantarena_event_admin_entrytypes'));

            } catch (\Exception $e) {
                $flashbag->add('error', $translator->trans('event.admin.entrytypes.edit.flash_error'));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/delete/{id}", name="nantarena_event_admin_entrytypes_delete")
     * @Template()
     */
    public function deleteAction(Request $request, EntryType $type)
    {
        $form = $this->createDeleteForm($type->getId());
        $form->handleRequest($request);

        if ($form->isValid()) {
            $translator = $this->get('translator');
            $flashbag = $this->get('session')->getFlashBag();

            try {
                if ($form->get('id')->getData() == $type->getId()) {
                    $em = $this->getDoctrine()->getManager();
                    $em->remove($type);
                    $em->flush();

                    $flashbag->add('success', $translator->trans('event.admin.entrytypes.delete.flash_success'));
                } else {
                    throw new \Exception;
                }
            } catch (\Exception $e) {
                $flashbag->add('error', $translator->trans('event.admin.entrytypes.delete.flash_error'));
            }

            return $this->redirect($this->generateUrl('nantarena_event_admin_entrytypes'));
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to delete an EntryType entity by id.
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
            ->setAction($this->generateUrl('nantarena_event_admin_entrytypes_delete', array(
                'id' => $id
            )))
            ->getForm();
    }
}
