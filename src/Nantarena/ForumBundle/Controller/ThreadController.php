<?php

namespace Nantarena\ForumBundle\Controller;

use Nantarena\ForumBundle\Entity\Forum;
use Nantarena\ForumBundle\Entity\Post;
use Nantarena\ForumBundle\Entity\Thread;
use Nantarena\ForumBundle\Form\Type\PostType;
use Nantarena\ForumBundle\Form\Type\ThreadType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class ThreadController extends Controller
{
    /**
     * @Route("/{categoryId}-{categorySlug}/{id}-{slug}/create")
     * @Template()
     */
    public function createAction(Request $request, $categoryId, $categorySlug, Forum $forum)
    {
        $thread = new Thread();
        $form = $this->createForm(new ThreadType(), $thread)->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $post = new Post();

            $post
                ->setUser($user)
                ->setThread($thread)
                ->setContent($form->get('content')->getData());

            $thread
                ->setForum($forum)
                ->setUser($user)
                ->addPost($post);

            $em->persist($thread);
            $em->persist($post);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('forum.thread.create.flash_success'));

            return $this->redirect($this->get('nantarena_forum.thread_manager')->getThreadPath($thread, $thread->getLastPage()));
        }

        $this->get('nantarena_site.breadcrumb')
            ->push(
                $this->get('translator')->trans('forum.index.title'),
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
                $this->get('translator')->trans('forum.thread.create.title'),
                $this->get('nantarena_forum.thread_manager')->getThreadCreatePath($forum)
            );

        return array(
            'forum' => $forum,
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/{categoryId}-{categorySlug}/{forumId}-{forumSlug}/{id}-{slug}/reply")
     * @Template()
     */
    public function replyAction(Request $request, $categoryId, $categorySlug, $forumId, $forumSlug, Thread $thread)
    {
        $post = new Post();
        $form = $this->createForm(new PostType(), $post)->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();

            // mise à jour de l'activité du thread
            $thread->updateActivity();

            $post->setThread($thread);
            $post->setUser($user);

            $em->persist($post);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('forum.thread.reply.flash_success'));

            return $this->redirect($this->get('nantarena_forum.thread_manager')->getThreadPath($thread, $thread->getLastPage()));
        }

        $this->get('nantarena_site.breadcrumb')
            ->push(
                $this->get('translator')->trans('forum.index.title'),
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
            )
            ->push(
                $this->get('translator')->trans('forum.thread.reply.title', array(
                    '%thread%' => $thread->getName(),
                )),
                $this->get('nantarena_forum.thread_manager')->getThreadReplyPath($thread)
            );

        return array(
            'thread' => $thread,
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/{categoryId}-{categorySlug}/{forumId}-{forumSlug}/{id}-{slug}/{page}", requirements={"page" = "\d+"})
     * @Template()
     */
    public function showAction($categoryId, $categorySlug, $forumId, $forumSlug, Thread $thread, $page = 1)
    {
        $this->get('nantarena_site.breadcrumb')
            ->push(
                $this->get('translator')->trans('forum.index.title'),
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
            $thread->getPosts(), $page, 20
        );

        return array(
            'thread' => $thread,
            'pagination' => $pagination,
        );
    }
}
