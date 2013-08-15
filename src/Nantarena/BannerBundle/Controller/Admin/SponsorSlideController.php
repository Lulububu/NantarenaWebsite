<?php

namespace Nantarena\BannerBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
// Manage routing
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
// Request for form
use Symfony\Component\HttpFoundation\Request;

// Entity
use Nantarena\BannerBundle\Entity\SponsorSlide;
// Form type
use Nantarena\BannerBundle\Form\Type\SponsorSlideType;

/**
 * Class SponsorSlide
 *
 * @package Nantarena\BannerBundle\Controller\Admin
 *
 * @Route("/admin/sponsor-slide")
 */
class SponsorSlideController extends Controller
{
    /**
     * @Route("/", name="nantarena_banner_sponsorslide_index")
     * @Template()
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository('NantarenaBannerBundle:SponsorSlide');
        $slides = $repository->findAll();

        return array('slides' => $slides);
    }

    /**
     * @Route("/create", name="nantarena_banner_sponsorslide_create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $slide = new SponsorSlide();
        $slide->setActive(False);
        $slide->setContent('');

        $form = $this->createForm(new SponsorSlideType(), $slide, array(
            'action' => $this->get('nantarena_banner.sponsor_slide_manager')->getCreatePath(),
            'method' => 'POST',
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            try {
                // add the new sponsor slide
                $em = $this->getDoctrine()->getManager();
                $em->persist($slide);

                // commit changes in database
                $em->flush();

                // messages
                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('banner.admin.sponsorslide.create.flash_success'));
                if ($slide->getActive()) {
                    $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('banner.admin.sponsorslide.create.flash_success_active'));
                }
            } catch (\Exception $e) {
                $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('banner.admin.sponsorslide.create.flash_error'));
            }

            return $this->redirect($this->generateUrl('nantarena_banner_sponsorslide_index'));
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/edit/{id}", name="nantarena_banner_sponsorslide_edit")
     * @Template()
     */
    public function editAction(Request $request, SponsorSlide $slide)
    {
        $form = $this->createForm(new SponsorSlideType(), $slide, array(
            'action' => $this->get('nantarena_banner.sponsor_slide_manager')->getEditPath($slide),
            'method' => 'POST',
        ));     

        $form->handleRequest($request);

        if ($form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('banner.admin.sponsorslide.edit.flash_success'));
            } catch (\Exception $e) {
                $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('banner.admin.sponsorslide.edit.flash_error'));
            }

            return $this->redirect($this->generateUrl('nantarena_banner_sponsorslide_index'));
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/active/{id}", name="nantarena_banner_sponsorslide_active")
     */
    public function activeAction(SponsorSlide $slide)
    {
        // check if the sponsor slide is really disabled
        if (!$slide->getActive())
        {
            try {

                // Active the slide and commit
                $slide->setActive(True);
                $em = $this->getDoctrine()->getManager();
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('banner.admin.sponsorslide.active.flash_success'));
            } catch (\Exception $e) {
                $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('banner.admin.sponsorslide.active.flash_error'));
            }
        }else
        {
            $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('banner.admin.sponsorslide.active.flash_error_state'));
        }

        return $this->redirect($this->generateUrl('nantarena_banner_sponsorslide_index'));
    }

    /**
     * @Route("/disable/{id}", name="nantarena_banner_sponsorslide_disable")
     */
    public function disableAction(SponsorSlide $slide)
    {
        if ($slide->getActive())
        {
            try {
                $slide->setActive(False);
                $em = $this->getDoctrine()->getManager();
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('banner.admin.sponsorslide.disable.flash_success'));
            } catch (\Exception $e) {
                $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('banner.admin.sponsorslide.disable.flash_error'));
            }
        }else
        {
            $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('banner.admin.sponsorslide.disable.flash_error_state'));
        }

        return $this->redirect($this->generateUrl('nantarena_banner_sponsorslide_index'));
    }

    /**
     * @Route("/delete/{id}", name="nantarena_banner_sponsorslide_delete")
     * @Template()
     */
    public function deleteAction(Request $request, SponsorSlide $slide)
    {
        $form = $this->createDeleteForm($slide->getId());

        $form->handleRequest($request);

        if ($form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->remove($slide);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('banner.admin.sponsorslide.delete.flash_success'));
            } catch (\Exception $e) {
                $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('banner.admin.sponsorslide.delete.flash_error'));
            }

            return $this->redirect($this->generateUrl('nantarena_banner_sponsorslide_index'));
        }

        return array(
            'form' => $form->createView(),
            'slide' => $slide,
        );
    }

    /**
     * Creates a form to delete a sponsor slide entity by id.
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
            ->setAction($this->generateUrl('nantarena_banner_sponsorslide_delete', array(
                'id' => $id
            )))
            ->getForm();
    }
}