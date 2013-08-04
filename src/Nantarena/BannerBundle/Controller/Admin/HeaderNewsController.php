<?php

namespace Nantarena\BannerBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
// Manage routing
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
// Request for form
use Symfony\Component\HttpFoundation\Request;

// Entity
use Nantarena\BannerBundle\Entity\HeaderNews;
// Form type
use Nantarena\BannerBundle\Form\Type\HeaderNewsType;

/**
 * Class HeaderNewsController
 *
 * @package Nantarena\BannerBundle\Controller\Admin
 *
 * @Route("/admin/header-news")
 */
class HeaderNewsController extends Controller
{
    /**
     * @Route("/", name="nantarena_banner_news_index")
     * @Template()
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository('NantarenaBannerBundle:HeaderNews');
        $lhnews = $repository->findAll();

        return array('lhnews' => $lhnews);
    }

    /**
     * @Route("/create", name="nantarena_banner_news_create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $hnews = new HeaderNews();
        $hnews->setActive(False);
        $hnews->setContent('');

        $form = $this->createForm(new HeaderNewsType(), $hnews, array(
            'action' => $this->get('nantarena_banner.header_news_manager')->getCreatePath(),
            'method' => 'POST',
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            // reset current header news if the new one is activated
            try {
                if($hnews->getActive())
                {
                    $repository = $this->getDoctrine()
                        ->getRepository('NantarenaBannerBundle:HeaderNews');
                    $oldhnews = $repository->findOneBy(array('active' => True));

                    if ($oldhnews) {
                        $oldhnews->setActive(False);
                    }
                }
                // add the new header news
                $em = $this->getDoctrine()->getManager();
                $em->persist($hnews);

                // commit changes in database
                $em->flush();

                // messages
                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('banner.admin.headernews.create.flash_success'));
                if ($hnews->getActive()) {
                    $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('banner.admin.headernews.create.flash_success_active'));
                }
            } catch (ORMException $e) {
                $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('banner.admin.headernews.create.flash_error'));
            }

            return $this->redirect($this->generateUrl('nantarena_banner_news_index'));
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/edit/{id}", name="nantarena_banner_news_edit")
     * @Template()
     */
    public function editAction(Request $request, HeaderNews $hnews)
    {
        $form = $this->createForm(new HeaderNewsType(false), $hnews, array(
            'action' => $this->get('nantarena_banner.header_news_manager')->getEditPath($hnews),
            'method' => 'POST',
        ));     

        $form->handleRequest($request);

        if ($form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('banner.admin.headernews.edit.flash_success'));
            } catch (ORMException $e) {
                $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('banner.admin.headernews.edit.flash_error'));
            }

            return $this->redirect($this->generateUrl('nantarena_banner_news_index'));
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/active/{id}", name="nantarena_banner_news_active")
     * @Template()
     */
    public function activeAction(HeaderNews $hnews)
    {
        // check if the header news is relly disabled
        if (!$hnews->getActive())
        {
            try {
                // Get the old activated header news
                $repository = $this->getDoctrine()
                    ->getRepository('NantarenaBannerBundle:HeaderNews');
                $oldhnews = $repository->findOneBy(array('active' => True));

                if ($oldhnews) {
                    $oldhnews->setActive(False);
                }

                // Active the news and commit
                $hnews->setActive(True);
                $em = $this->getDoctrine()->getManager();
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('banner.admin.headernews.active.flash_success'));
            } catch (ORMException $e) {
                $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('banner.admin.headernews.active.flash_error'));
            }
        }

        return $this->redirect($this->generateUrl('nantarena_banner_news_index'));
    }

    /**
     * @Route("/delete/{id}", name="nantarena_banner_news_delete")
     * @Template()
     */
    public function deleteAction(Request $request, HeaderNews $hnews)
    {
        $form = $this->createDeleteForm($hnews->getId());

        $form->handleRequest($request);

        if ($form->isValid()) {
            // check if the header news is not active
            if (!$hnews->getActive())
            {
                try {
                    $em = $this->getDoctrine()->getManager();
                    $em->remove($hnews);
                    $em->flush();
                    $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('banner.admin.headernews.delete.flash_success'));
                } catch (ORMException $e) {
                    $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('banner.admin.headernews.delete.flash_error'));
                }
            }else
            {
                $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('banner.admin.headernews.delete.flash_error_active'));
            }

            return $this->redirect($this->generateUrl('nantarena_banner_news_index'));
        }

        return array(
            'form' => $form->createView(),
            'hnews' => $hnews,
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
            ->setAction($this->generateUrl('nantarena_banner_news_delete', array(
                'id' => $id
            )))
            ->getForm();
    }
}