<?php

namespace Nantarena\ForumBundle\Controller;

use Nantarena\ForumBundle\Entity\Forum;
use Nantarena\SiteBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route("/forum")
 */
class ForumController extends BaseController
{
    /**
     * @Route("/{category_id}-{category_slug}/{id}-{slug}/{page}", requirements={"page" = "\d+"})
     * @ParamConverter("forum", class="NantarenaForumBundle:Forum", options={"repository_method" = "findWithJoins"})
     * @Template()
     */
    public function indexAction(Forum $forum, $page = 1)
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
