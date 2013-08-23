<?php

namespace Nantarena\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/forum")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $categories = $this->getDoctrine()->getRepository('NantarenaForumBundle:Category')->findAllWithForums();

        $this->get('nantarena_site.breadcrumb')->push(
            $this->get('translator')->trans('forum.index.title'),
            $this->generateUrl('nantarena_forum_default_index')
        );

        return array(
            'categories' => $categories,
        );
    }

    /**
     * @Route("/unreads/{page}")
     * @Template()
     */
    public function unreadsAction($page = 1)
    {
        $this->get('nantarena_site.breadcrumb')
            ->push(
                $this->get('translator')->trans('forum.index.title'),
                $this->generateUrl('nantarena_forum_default_index')
            )
            ->push(
                $this->get('translator')->trans('forum.unreads.title'),
                $this->generateUrl('nantarena_forum_default_unreads')
            );

        $unreads = $this->getDoctrine()->getRepository('NantarenaForumBundle:ReadStatus')->findOneByUser($this->getUser());
        $pagination = $this->get('knp_paginator')->paginate(
            $unreads->getThreads(), $page, 20
        );

        return array(
            'pagination' => $pagination,
        );
    }
}
