<?php

namespace Nantarena\BannerBundle\Controller;

use Nantarena\AdminBundle\Controller\DashboardInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller implements DashboardInterface
{
    public function dashboardAction()
    {
        $translator = $this->get('translator');

        return array(
            'module_title' => $translator->trans('banner.admin.dashboard.title'),
            'module_links' => array(
                $translator->trans('banner.admin.dashboard.hnews_management') => array(
                    'url' => $this->generateUrl('nantarena_banner_news_index'),
                    'role' => 'ROLE_BANNER_ADMIN_HEADERNEWS'
                ),
                $translator->trans('banner.admin.dashboard.sponsorslide_management') => array(
                    'url' => $this->generateUrl('nantarena_banner_sponsorslide_index'),
                    'role' => 'ROLE_BANNER_ADMIN_SPONSOR_SLIDE'
                ),
            )
        );
    }
}