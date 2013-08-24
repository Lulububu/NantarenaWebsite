<?php

namespace Nantarena\ForumBundle\Controller\Admin;

use Doctrine\ORM\ORMException;
use Nantarena\ForumBundle\Entity\Forum;
use Nantarena\ForumBundle\Entity\Thread;
use Nantarena\ForumBundle\Form\Type\ForumType;
use Nantarena\ForumBundle\Repository\ForumRepository;
use Nantarena\SiteBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin/forum/forums")
 */
class ForumsController extends BaseController
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
    public function editAction(Request $request, Forum $forum)
    {
        $form = $this->createForm(new ForumType(), $forum, array(
            'action' => $this->get('nantarena_forum.forum_manager')->getEditPath($forum),
            'method' => 'POST',
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            try {
                $this->getDoctrine()->getManager()->flush();

                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('forum.admin.forums.edit.flash_success', array(
                    '%name%' => $forum->getName(),
                )));

                return $this->redirect($this->get('nantarena_forum.forum_manager')->getEditPath($forum));
            } catch (\Exception $e) {
                $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('forum.admin.forums.edit.flash_error', array(
                    '%name%' => $forum->getName(),
                )));
            }
        }

        return array(
            'forum' => $forum,
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/delete/{id}")
     * @Template()
     */
    public function deleteAction(Request $request, Forum $forum)
    {
        $form = $this->createDeleteForm($forum->getId());

        $form->handleRequest($request);

        if ($form->isValid()) {
            if ($form->get('id')->getData() == $forum->getId() && $form->get('forum')->getData()->getId() !== $forum->getId()) {
                $em = $this->getDoctrine()->getManager();

                $threads = $em->getRepository('NantarenaForumBundle:Thread')->findBy(array(
                    'forum' => $forum->getId(),
                ));

                /** @var Thread $thread */
                foreach ($threads as $thread) {
                    $thread->setForum($form->get('forum')->getData());
                }

                $em->remove($forum);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('forum.admin.forums.delete.flash_success'));
            } else {
                $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('forum.admin.forums.delete.flash_error'));
            }

            return $this->redirect($this->generateUrl('nantarena_forum_admin_forums_index'));
        }

        return array(
            'form' => $form->createView(),
            'forum' => $forum,
        );
    }

    /**
     * @Route("/create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $forum = new Forum();
        $form = $this->createForm(new ForumType(), $forum, array(
            'action' => $this->get('nantarena_forum.forum_manager')->getCreatePath(),
            'method' => 'POST',
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();

                $em->persist($forum);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('forum.admin.forums.create.flash_success', array(
                    '%name%' => $forum->getName(),
                )));

                return $this->redirect($this->generateUrl('nantarena_forum_admin_forums_index'));
            } catch (ORMException $e) {
                $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('forum.admin.forums.create.flash_error', array(
                    '%name%' => $forum->getName(),
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
            ->add('forum', 'entity', array(
                'class' => 'Nantarena\ForumBundle\Entity\Forum',
                'property' => 'name',
                'query_builder' => function(ForumRepository $er) use ($id) {
                    return $er->createQueryBuilder('f')
                        ->where('f.id <> :id')
                        ->setParameter('id', $id);
                },
                'group_by' => 'category.name'
            ))
            ->add('id', 'hidden')
            ->add('submit', 'submit')
            ->setMethod('POST')
            ->setAction($this->generateUrl('nantarena_forum_admin_forums_delete', array(
                'id' => $id
            )))
            ->getForm();
    }
}
