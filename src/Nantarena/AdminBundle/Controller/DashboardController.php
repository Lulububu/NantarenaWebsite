<?php

namespace Nantarena\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    /**
     * @Route("/", name="nantarena_admin_index")
     * @Template()
     */
    public function indexAction()
    {
        $dashboard = $this->get('nantarena_admin.dashboard_service');

        $modules = array();
        $modulesClasses = $dashboard->getModules();

        foreach ($modulesClasses as $moduleClass) {
            $moduleController = new $moduleClass();
            $moduleController->setContainer($this->container);
            $content = $moduleController->dashboardAction();

            if ($content instanceof Response) {
                $modules[] = $content->getContent();
            } else {
                $modules[] = $this->get('templating')->render(
                    'NantarenaAdminBundle:Dashboard:_module.html.twig',
                    $content
                );
            }
        }

        return array('modules' => $modules);
    }
}
