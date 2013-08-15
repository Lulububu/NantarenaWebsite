<?php

namespace Nantarena\ContactBundle\Controller;

use Nantarena\AdminBundle\Controller\DashboardInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller implements DashboardInterface
{
    public function dashboardAction()
    {
        $translator = $this->get('translator');

        return array(
            'module_title' => $translator->trans('contact.admin.dashboard.title'),
            'module_links' => array(
                $translator->trans('contact.admin.dashboard.category') => array(
                    'url' => $this->generateUrl('nantarena_admin_contact_category_list'),
                    'role' => 'ROLE_CONTACT_ADMIN_CATEGORY'
                ),
            )
        );
    }
}