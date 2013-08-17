<?php

namespace Nantarena\ForumBundle\Controller;

use Nantarena\ForumBundle\Entity\Forum;
use Nantarena\SiteBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ForumController extends BaseController
{
    /**
     * @Route("/{categoryId}-{categorySlug}/{id}-{slug}/{page}", requirements={"page" = "\d+"})
     * @Template()
     */
    public function indexAction($categoryId, $categorySlug, Forum $forum, $page = 1)
    {
        if (!$this->getSecurityContext()->isGranted('VIEW', $forum)) {
            throw new AccessDeniedException();
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
            );

        $pagination = $this->get('knp_paginator')->paginate(
            $forum->getThreads(), $page, 20
        );

        return array(
            'forum' => $forum,
            'pagination' => $pagination,
        );
    }

}
