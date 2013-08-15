<?php

namespace Nantarena\NewsBundle\Controller;

use Nantarena\NewsBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Nantarena\NewsBundle\Entity\News;

/**
 * Class NewsController
 *
 * @package Nantarena\NewsBundle\Controller
 *
 * @Route("/news")
 */
class CategoryController extends Controller
{
    /**
     * @Route("/categories", name="nantarena_news_category_categories")
     * @Template()
     */
    public function categoriesAction()
    {
        return array(
            'categories' => $this->getDoctrine()->getRepository('NantarenaNewsBundle:Category')->findAll(),
        );
    }

    /**
     * @Route("/{slug}/{page}", name="nantarena_news_category_index")
     * @Template()
     */
    public function indexAction(Category $category, $page = 1)
    {
        $limit = $this->getRequest()->get('limit', 5);

        $pagination = $this->get('knp_paginator')->paginate(
            $this->getDoctrine()->getRepository('NantarenaNewsBundle:News')->findAllPublishedByCategory($category),
            $page, $limit
        );

        $this->get('nantarena_site.breadcrumb')
            ->push(
                $this->get('translator')->trans('site.menu.news'),
                $this->generateUrl('nantarena_news_index')
            )
            ->push(
                $category->getName(),
                $this->get('nantarena_news.category_manager')->getCategoryPath($category)
            );

        return array(
            'pagination' => $pagination,
            'category' => $category,
        );
    }
}
