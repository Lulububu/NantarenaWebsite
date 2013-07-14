<?php

namespace Nantarena\UserBundle\Controller;

use Nantarena\AdminBundle\Controller\DashboardInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AdminController extends Controller implements DashboardInterface
{
    public function dashboardAction()
    {
        $translator = $this->get('translator');

        return array(
            'module_title' => $translator->trans('user.admin.dashboard.title'),
            'module_links' => array(
                $translator->trans('user.admin.dashboard.users_management') =>
                    $this->generateUrl('nantarena_user_admin_users'),
                $translator->trans('user.admin.dashboard.groups_management') =>
                    $this->generateUrl('nantarena_user_admin_groups'),
            )
        );
    }
}
