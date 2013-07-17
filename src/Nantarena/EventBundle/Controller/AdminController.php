<?php

namespace Nantarena\EventBundle\Controller;

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
            'module_title' => $translator->trans('event.admin.dashboard.title'),
            'module_links' => array(
                $translator->trans('event.admin.dashboard.entrytypes_management') => array(
                    'url' => $this->generateUrl('nantarena_event_admin_entrytypes'),
                    'role' => 'ROLE_EVENT_ADMIN_ENTRYTYPES'
                ),
            )
        );
    }
}
