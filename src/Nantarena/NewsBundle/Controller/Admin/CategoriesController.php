<?php

namespace Nantarena\NewsBundle\Controller\Admin;

use Doctrine\ORM\ORMException;
use Doctrine\ORM\EntityRepository;
use Nantarena\NewsBundle\Entity\Category;
use Nantarena\NewsBundle\Form\Type\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AdminController
 *
 * @package Nantarena\NewsBundle\Controller\Admin
 *
 * @Route("/admin/news/categories")
 */
class CategoriesController extends Controller
{
    /**
     * @Route("/", name="nantarena_news_admin_categories_index")
     * @Template()
     */
    public function indexAction()
    {
        return array(
            'categories' => $this->getDoctrine()->getRepository('NantarenaNewsBundle:Category')->findAll(),
        );
    }

    /**
     * @Route("/edit/{id}", name="nantarena_news_admin_categories_edit")
     * @Template()
     */
    public function editAction(Request $request, Category $category)
    {
        $form = $this->createForm(new CategoryType(), $category, array(
            'action' => $this->get('nantarena_news.category_manager')->getEditPath($category),
            'method' => 'POST',
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();

                $em->persist($category);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('news.admin.categories.edit.flash_success', array(
                    '%name%' => $category->getName(),
                )));

                return $this->redirect($this->get('nantarena_news.category_manager')->getEditPath($category));
            } catch (\Exception $e) {
                $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('news.admin.categories.edit.flash_error', array(
                    '%name%' => $category->getName(),
                )));
            }
        }

        return array(
            'category' => $category,
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/delete/{id}", name="nantarena_news_admin_categories_delete")
     * @Template()
     */
    public function deleteAction(Request $request, Category $category)
    {
        $form = $this->createDeleteForm($category->getId());

        $form->handleRequest($request);

        if ($form->isValid()) {
            if ($form->get('id')->getData() == $category->getId() && $form->get('category')->getData()->getId() !== $category->getId()) {
                $em = $this->getDoctrine()->getManager();

                $news = $em->getRepository('NantarenaNewsBundle:News')->findBy(array(
                    'category' => $category->getId(),
                ));

                foreach ($news as $n) {
                    $n->setCategory($form->get('category')->getData());
                }

                $em->remove($category);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('news.admin.categories.delete.flash_success'));
            } else {
                $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('news.admin.categories.delete.flash_error'));
            }

            return $this->redirect($this->generateUrl('nantarena_news_admin_categories_index'));
        }

        return array(
            'form' => $form->createView(),
            'category' => $category,
        );
    }

    /**
     * @Route("/create", name="nantarena_news_admin_categories_create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(new CategoryType(), $category, array(
            'action' => $this->get('nantarena_news.category_manager')->getCreatePath(),
            'method' => 'POST',
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();

                $em->persist($category);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('news.admin.categories.create.flash_success', array(
                    '%name%' => $category->getName(),
                )));

                return $this->redirect($this->generateUrl('nantarena_news_admin_categories_index'));
            } catch (ORMException $e) {
                $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('news.admin.categories.create.flash_error', array(
                    '%name%' => $category->getName(),
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
            ->add('category', 'entity', array(
                'class' => 'Nantarena\NewsBundle\Entity\Category',
                'property' => 'name',
                'query_builder' => function(EntityRepository $er) use ($id) {
                    return $er->createQueryBuilder('c')
                        ->where('c.id <> :id')
                        ->setParameter('id', $id);
                }
            ))
            ->add('id', 'hidden')
            ->add('submit', 'submit')
            ->setMethod('POST')
            ->setAction($this->generateUrl('nantarena_news_admin_categories_delete', array(
                'id' => $id
            )))
            ->getForm();
    }
}
