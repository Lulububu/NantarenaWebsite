<?php

namespace Nantarena\ForumBundle\Controller;

use Nantarena\ForumBundle\Entity\Forum;
use Nantarena\ForumBundle\Entity\Post;
use Nantarena\ForumBundle\Entity\Thread;
use Nantarena\ForumBundle\Form\Type\ThreadType;
use Nantarena\SiteBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ThreadController extends BaseController
{
    /**
     * @Route("/{category_id}-{category_slug}/{id}-{slug}/create")
     * @ParamConverter("forum", class="NantarenaForumBundle:Forum", options={"repository_method" = "findWithJoins"})
     * @Template()
     */
    public function createAction(Request $request, Forum $forum)
    {
        // On ne peut créer un Thread que dans un forum dont on a accès
        if (!$this->getSecurityContext()->isGranted('VIEW', $forum)) {
            throw new AccessDeniedException();
        }

        $thread = new Thread();
        $form = $this->createForm(new ThreadType(), $thread)->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $post = new Post();

            $post
                ->setUser($user)
                ->setThread($thread)
                // non mappé dans le form donc on le récupère manuellement
                ->setContent($form->get('content')->getData());

            $thread
                ->setForum($forum)
                ->setUser($user)
                ->addPost($post);

            $em->persist($thread);
            $em->persist($post);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', $this->trans('forum.thread.create.flash_success'));

            return $this->redirect($this->get('nantarena_forum.thread_manager')->getThreadPath($thread, $thread->getLastPage()));
        }

        $this->get('nantarena_site.breadcrumb')
            ->push(
                $this->trans('forum.index.title'),
                $this->generateUrl('nantarena_forum_default_index')
            )
            ->push(
                $forum->getCategory()->getName(),
                $this->get('nantarena_forum.category_manager')->getCategoryPath($forum->getCategory())
            )
            ->push(
                $forum->getName(),
                $this->get('nantarena_forum.forum_manager')->getForumPath($forum)
            )
            ->push(
                $this->trans('forum.thread.create.title'),
                $this->get('nantarena_forum.thread_manager')->getCreatePath($forum)
            );

        return array(
            'forum' => $forum,
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/{category_id}-{category_slug}/{forum_id}-{forum_slug}/{id}-{slug}/{page}", requirements={"page" = "\d+"})
     * @ParamConverter("thread", class="NantarenaForumBundle:Thread", options={"repository_method" = "findWithJoins"})
     * @Template()
     */
    public function showAction(Thread $thread, $page = 1)
    {
        // Pour un thread on check le forum du thread en accès VIEW (et pas directement le thread en lui même)
        if (!$this->getSecurityContext()->isGranted('VIEW', $thread->getForum())) {
            throw new AccessDeniedException();
        }

        $this->get('nantarena_site.breadcrumb')
            ->push(
                $this->trans('forum.index.title'),
                $this->generateUrl('nantarena_forum_default_index')
            )
            ->push(
                $thread->getForum()->getCategory()->getName(),
                $this->get('nantarena_forum.category_manager')->getCategoryPath($thread->getForum()->getCategory())
            )
            ->push(
                $thread->getForum()->getName(),
                $this->get('nantarena_forum.forum_manager')->getForumPath($thread->getForum())
            )
            ->push(
                $thread->getName(),
                $this->get('nantarena_forum.thread_manager')->getThreadPath($thread)
            );

        $pagination = $this->get('knp_paginator')->paginate(
            $thread->getPosts(), $page, Thread::POSTS_PER_PAGE
        );

        return array(
            'thread' => $thread,
            'pagination' => $pagination,
        );
    }

    /**
     * @Route("/thread/lock/{id}")
     */
    public function lockAction(Thread $thread)
    {
        if (!$this->getSecurityContext()->isGranted('OPERATOR', $thread)) {
            throw new AccessDeniedException();
        }

        if ($thread->isLocked()) {
            $thread->open();
            $this->addFlash('success', 'forum.thread.lock.unlock_success');
        } else {
            $thread->close();
            $this->addFlash('success', 'forum.thread.lock.lock_success');
        }

        $this->getDoctrine()->getManager()->flush();

        return $this->redirect($this->get('nantarena_forum.thread_manager')->getThreadPath($thread));
    }

    /**
     * @Route("/thread/delete/{id}")
     */
    public function deleteAction(Thread $thread)
    {
        if (!$this->getSecurityContext()->isGranted('DELETE', $thread)) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $em->remove($thread);
        $em->flush();

        $this->addFlash('success', 'forum.thread.delete.flash_success');

        return $this->redirect($this->get('nantarena_forum.forum_manager')->getForumPath($thread->getForum()));
    }
}
