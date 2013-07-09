<?php

namespace Nantarena\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Nantarena\NewsBundle\Entity\Comment;
use Nantarena\NewsBundle\Entity\News;
use Nantarena\NewsBundle\Form\Type\CommentType;

/**
 * Class CommentController
 *
 * @package Nantarena\NewsBundle\Controller
 *
 * @Route("/news/comment")
 */
class CommentController extends Controller
{
    /**
     * @Route("/create/{id}", name="nantarena_news_comment_create")
     */
    public function createAction(Request $request, News $news)
    {
        if (News::STATE_UNPUBLISHED === $news->getState()) {
            return $this->redirect($this->generateUrl('nantarena_news_index'));
        }

        $comment = new Comment();
        $form = $this->createForm(new CommentType(), $comment, array(
            'action' => $this->get('nantarena_news.comment_manager')->getCreateCommentPath($news),
            'method' => 'POST',
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $comment->setNews($news);
            $comment->setAuthor($this->getUser());

            $em->persist($comment);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('news.comment.create.flash_success'));
        } else {
            $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('news.comment.create.flash_error'));
        }

        return $this->redirect($this->get('nantarena_news.news_manager')->getNewsPath($news));
    }

    /**
     * @Route("/delete/{id}", name="nantarena_news_comment_delete")
     */
    public function deleteAction(Comment $comment)
    {
        if ($comment->getAuthor() !== $this->getUser()) {
            $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('news.comment.delete.flash_error'));
        } else {
            $em = $this->getDoctrine()->getManager();

            $em->remove($comment);
            $em->flush();

            $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('news.comment.delete.flash_success'));
        }

        return $this->redirect($this->get('nantarena_news.news_manager')->getNewsPath($comment->getNews()));
    }
}