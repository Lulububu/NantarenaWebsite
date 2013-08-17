<?php

namespace Nantarena\ForumBundle\Controller;

use Nantarena\AdminBundle\Controller\DashboardInterface;
use Nantarena\SiteBundle\Controller\BaseController;

class AdminController extends BaseController implements DashboardInterface
{
    public function dashboardAction()
    {
        $translator = $this->get('translator');

        return array(
            'module_title' => $translator->trans('forum.admin.dashboard.title'),
            'module_links' => array(
                $translator->trans('forum.admin.dashboard.categories_management') => array(
                    'url' => $this->generateUrl('nantarena_forum_admin_categories_index'),
                    'role' => 'ROLE_FORUM_ADMIN'
                ),
                $translator->trans('forum.admin.dashboard.forum_management') => array(
                    'url' => $this->generateUrl('nantarena_forum_admin_forums_index'),
                    'role' => 'ROLE_FORUM_ADMIN'
                ),
            )
        );
    }
}
