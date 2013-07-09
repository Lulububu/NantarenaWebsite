<?php

namespace Nantarena\NewsBundle\Controller;

use Doctrine\ORM\ORMException;
use Nantarena\NewsBundle\Entity\News;
use Nantarena\NewsBundle\Form\Type\NewsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AdminController
 *
 * @package Nantarena\NewsBundle\Controller
 *
 * @Route("/admin/news")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="nantarena_news_admin_index")
     * @Template()
     */
    public function indexAction()
    {
        return array(
            'news' => $this->getDoctrine()->getRepository('NantarenaNewsBundle:News')->findBy(array(), array(
                'id' => 'desc',
            ))
        );
    }

    /**
     * @Route("/edit/{id}", name="nantarena_news_admin_edit")
     * @Template()
     */
    public function editAction(Request $request, News $news)
    {
        $form = $this->createForm(new NewsType(), $news, array(
            'action' => $this->get('nantarena_news.news_manager')->getEditPath($news),
            'method' => 'POST',
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();

                $em->persist($news);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('news.admin.edit.flash_success', array(
                    '%title%' => $news->getTitle(),
                )));

                return $this->redirect($this->get('nantarena_news.news_manager')->getEditPath($news));
            } catch (\Exception $e) {
                $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('news.admin.edit.flash_error', array(
                    '%title%' => $news->getTitle(),
                )));
            }
        }

        return array(
            'news' => $news,
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/delete/{id}", name="nantarena_news_admin_delete")
     * @Template()
     */
    public function deleteAction(Request $request, News $news)
    {
        $form = $this->createDeleteForm($news->getId());

        $form->handleRequest($request);

        if ($form->isValid()) {
            if ($form->get('id')->getData() == $news->getId()) {
                $em = $this->getDoctrine()->getManager();

                $em->remove($news);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('news.admin.delete.flash_success'));
            } else {
                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('news.admin.delete.flash_error'));
            }

            return $this->redirect($this->generateUrl('nantarena_news_admin_index'));
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/create", name="nantarena_news_admin_create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $news = new News();
        $form = $this->createForm(new NewsType(), $news, array(
            'action' => $this->get('nantarena_news.news_manager')->getCreatePath(),
            'method' => 'POST',
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();

                $news->setAuthor($this->getUser());

                $em->persist($news);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('news.admin.create.flash_success', array(
                    '%title%' => $news->getTitle(),
                )));

                return $this->redirect($this->generateUrl('nantarena_news_admin_index'));
            } catch (ORMException $e) {
                $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('news.admin.create.flash_error', array(
                    '%title%' => $news->getTitle(),
                )));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to delete a News entity by id.
     *
     * @param integer $id
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->add('delete', 'submit')
            ->setAction($this->generateUrl('nantarena_news_admin_delete', array(
                'id' => $id
            )))
            ->getForm();
    }
}
