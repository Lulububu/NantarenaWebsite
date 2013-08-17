<?php

namespace Nantarena\ForumBundle\Controller\Admin;

use Doctrine\ORM\ORMException;
use Nantarena\ForumBundle\Entity\Category;
use Nantarena\ForumBundle\Form\Type\CategoryType;
use Nantarena\ForumBundle\Repository\CategoryRepository;
use Nantarena\SiteBundle\Controller\BaseController;
use Nantarena\UserBundle\Entity\Group;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin/forum/categories")
 */
class CategoriesController extends BaseController
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return array(
            'categories' => $this->getDoctrine()->getRepository('NantarenaForumBundle:Category')->findBy(array(), array(
                'position' => 'asc',
            )),
        );
    }

    /**
     * @Route("/edit/{id}")
     * @Template()
     */
    public function editAction(Request $request, Category $category)
    {
        $form = $this->createForm(new CategoryType(), $category, array(
            'action' => $this->get('nantarena_forum.category_manager')->getEditPath($category),
            'method' => 'POST',
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            try {
                $this->getDoctrine()->getManager()->flush();

                // Mise à jour des Acl pour la catégorie, on supprime les anciennes et on ajoute de nouvelles
                // règles dans la db
                $this->deleteAcl($category);
                $this->createAcl($category, $form->get('groups')->getData());

                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('forum.admin.categories.edit.flash_success', array(
                    '%name%' => $category->getName(),
                )));

                return $this->redirect($this->get('nantarena_forum.category_manager')->getEditPath($category));
            } catch (\Exception $e) {
                $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('forum.admin.categories.edit.flash_error', array(
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
     * @Route("/delete/{id}")
     * @Template()
     */
    public function deleteAction(Request $request, Category $category)
    {
        $form = $this->createDeleteForm($category->getId());

        $form->handleRequest($request);

        if ($form->isValid()) {
            if ($form->get('id')->getData() == $category->getId() && $form->get('category')->getData()->getId() !== $category->getId()) {
                $em = $this->getDoctrine()->getManager();

                $forums = $em->getRepository('NantarenaForumBundle:Forum')->findBy(array(
                    'category' => $category->getId(),
                ));

                foreach ($forums as $forum) {
                    $forum->setCategory($form->get('category')->getData());
                }

                // Suppression des Acl relatives à la catégorie
                $this->deleteAcl($category);

                $em->remove($category);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('forum.admin.categories.delete.flash_success'));
            } else {
                $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('forum.admin.categories.delete.flash_error'));
            }

            return $this->redirect($this->generateUrl('nantarena_forum_admin_categories_index'));
        }

        return array(
            'form' => $form->createView(),
            'category' => $category,
        );
    }

    /**
     * @Route("/create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(new CategoryType(), $category, array(
            'action' => $this->get('nantarena_forum.category_manager')->getCreatePath(),
            'method' => 'POST',
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();

                $em->persist($category);
                $em->flush();

                // Création des Acl pour la catégorie, attention ici à l'appeller après le flush
                // afin d'avoir un id généré
                $this->createAcl($category, $form->get('groups')->getData());

                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('forum.admin.categories.create.flash_success', array(
                    '%name%' => $category->getName(),
                )));

                return $this->redirect($this->generateUrl('nantarena_forum_admin_categories_index'));
            } catch (ORMException $e) {
                $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('forum.admin.categories.create.flash_error', array(
                    '%name%' => $category->getName(),
                )));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to delete a forum entity by id.
     *
     * @param integer $id
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('category', 'entity', array(
                'class' => 'Nantarena\ForumBundle\Entity\Category',
                'property' => 'name',
                'query_builder' => function(CategoryRepository $er) use ($id) {
                    return $er->createQueryBuilder('c')
                        ->where('c.id <> :id')
                        ->setParameter('id', $id);
                }
            ))
            ->add('id', 'hidden')
            ->add('submit', 'submit')
            ->setMethod('POST')
            ->setAction($this->generateUrl('nantarena_forum_admin_categories_delete', array(
                'id' => $id
            )))
            ->getForm();
    }

    private function createAcl(Category $category, $groups)
    {
        // Récupération des roles pertinents pour la catégorie
        $roles = array();

        /** @var \Nantarena\UserBundle\Entity\Group $group */
        foreach ($groups as $group) {
            $roles[] = 'ROLE_GROUP_'.$group->getId();
        }

        // Création des Acl relatives à la nouvelle catégorie
        $this->get('nantarena_forum.acl_manager')->createAclForCategory($category, $roles);
    }

    private function deleteAcl(Category $category)
    {
        $this->get('nantarena_forum.acl_manager')->deleteAcl($category);
    }
}
