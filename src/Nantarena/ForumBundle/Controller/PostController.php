<?php

namespace Nantarena\ForumBundle\Controller;

use Nantarena\ForumBundle\Entity\Post;
use Nantarena\ForumBundle\Entity\Thread;
use Nantarena\ForumBundle\Form\Type\PostType;
use Nantarena\ForumBundle\Form\Type\ThreadType;
use Nantarena\SiteBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class PostController extends BaseController
{
    /**
     * @Route("/{category_id}-{category_slug}/{forum_id}-{forum_slug}/{id}-{slug}/reply")
     * @ParamConverter("thread", class="NantarenaForumBundle:Thread", options={"repository_method" = "findWithJoins"})
     * @Template()
     */
    public function replyAction(Request $request, Thread $thread)
    {
        // Accessible uniquement aux membres qui ont VIEW
        if (!$this->getSecurityContext()->isGranted('VIEW', $thread->getForum())) {
            throw new AccessDeniedException();
        }

        // On vérifie aussi que le topic n'est pas verrouillé
        if ($thread->isLocked() && !$this->getSecurityContext()->isGranted('OPERATOR', $thread)) {
            throw new AccessDeniedException();
        }

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

            $this->get('session')->getFlashBag()->add('success', $this->trans('forum.thread.reply.flash_success'));

            return $this->redirect($this->get('nantarena_forum.thread_manager')->getThreadPath($thread, $thread->getLastPage()).'#post-'.$post->getId());
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
            )
            ->push(
                $this->trans('forum.thread.reply.title', array(
                    '%thread%' => $thread->getName(),
                )),
                $this->get('nantarena_forum.thread_manager')->getReplyPath($thread)
            );

        return array(
            'thread' => $thread,
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/post/edit/{id}")
     * @ParamConverter("post", class="NantarenaForumBundle:Post", options={"repository_method" = "findWithJoins"})
     * @Template()
     */
    public function editAction(Request $request, Post $post)
    {
        if (!$this->getSecurityContext()->isGranted('EDIT', $post)) {
            throw new AccessDeniedException();
        }

        $thread = $post->getThread();
        $isThread = false;

        if ($post->getId() === $thread->getPosts()->first()->getId()) {
            $form = $this->createForm(new ThreadType(), $thread)->handleRequest($request);

            // Forçage du contenu depuis le contenu du Post
            if (!$form->isValid()) {
                $form->get('content')->setData($post->getContent());
            }

            $isThread = true;
        } else {
            $form = $this->createForm(new PostType(), $post)->handleRequest($request);
        }

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            // On met à jour le contenu du Post maitre à partir des données du formulaire
            if ($post->getId() === $thread->getPosts()->first()->getId()) {
                $post->setContent($form->get('content')->getData());
            }

            // Mise à jour du Post et Thread (si édition first Post) en db
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', $this->trans('forum.post.edit.flash_success'));

            return $this->redirect($this->get('nantarena_forum.thread_manager')->getThreadPath($thread, $thread->getPageForPost($post)).'#post-'.$post->getId());
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
            )
            ->push(
                $this->trans('forum.post.edit.title', array(
                    '%thread%' => $thread->getName(),
                )),
                $this->get('nantarena_forum.post_manager')->getEditPath($post)
            );

        return array(
            'thread' => $post->getThread(),
            'form' => $form->createView(),
            'is_thread' => $isThread,
        );
    }

    /**
     * @Route("/post/delete/{id}")
     * @ParamConverter("post", class="NantarenaForumBundle:Post", options={"repository_method" = "findWithJoins"})
     */
    public function deleteAction(Post $post)
    {
        if (!$this->getSecurityContext()->isGranted('DELETE', $post)) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $em->remove($post);
        $em->flush();

        $this->addFlash('success', 'forum.post.delete.flash_success');

        return $this->redirect($this->get('nantarena_forum.thread_manager')->getThreadPath($post->getThread()));
    }
}
