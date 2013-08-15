<?php

namespace Nantarena\NewsBundle\Controller;

use Nantarena\NewsBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Nantarena\NewsBundle\Entity\News;
use Nantarena\NewsBundle\Form\Type\CommentType;

/**
 * Class NewsController
 *
 * @package Nantarena\NewsBundle\Controller
 *
 * @Route("/news")
 */
class NewsController extends Controller
{
    /**
     * @Route("/", name="nantarena_news_index")
     * @Template()
     */
    public function indexAction()
    {
        $limit = $this->getRequest()->get('limit', 5);

        $pagination = $this->get('knp_paginator')->paginate(
            $this->getDoctrine()->getRepository('NantarenaNewsBundle:News')->findAllPublished(),
            $this->getRequest()->get('page', 1), $limit
        );

        return array(
            'pagination' => $pagination,
        );
    }

    /**
     * @Route("/{category}/{id}-{slug}", name="nantarena_news_show")
     * @Template()
     */
    public function showAction($category, News $news)
    {
        $category = $news->getCategory();

        if (News::STATE_UNPUBLISHED === $news->getState()) {
            if (!$this->get('security.context')->isGranted('ROLE_NEWS_ADMIN_NEWS')) {
                throw $this->createNotFoundException();
            }
        }

        $this->get('nantarena_site.breadcrumb')
            ->push(
                $this->get('translator')->trans('site.menu.news'),
                $this->generateUrl('nantarena_news_index')
            )
            ->push(
                $category->getName(),
                $this->get('nantarena_news.category_manager')->getCategoryPath($category)
            )
            ->push(
                $news->getTitle(),
                $this->get('nantarena_news.news_manager')->getNewsPath($news)
            );

        $form = $this->createForm(new CommentType(), null, array(
            'action' => $this->get('nantarena_news.comment_manager')->getCreateCommentPath($news),
            'method' => 'POST',
        ));

        return array(
            'news' => $news,
            'form' => $form->createView(),
        );
    }
}
