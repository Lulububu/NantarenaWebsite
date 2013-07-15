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
                if ($content->getStatusCode() == 200) {
                    $modules[] = $content->getContent();
                }
            } else {
                if ($this->validate($content)) {
                    $modules[] = $this->get('templating')->render(
                        'NantarenaAdminBundle:Dashboard:_module.html.twig',
                        $content
                    );
                }
            }
        }

        return array('modules' => $modules);
    }

    /**
     * @param $content
     * @return bool True if content is valid
     */
    private function validate(&$content)
    {
        if (isset($content['access']) && $content['access'] == false)
            return false;

        if (!isset($content['module_title']) || !isset($content['module_links']))
            return false;

        $access = false;
        $security = $this->get('security.context');

        foreach($content['module_links'] as &$link) {
            if (!isset($link['url']))
                $link['url'] = '#';

            if (!isset($link['role']))
                $link['role'] = 'ROLE_ADMIN';

            if ($security->isGranted($link))
                $access = true;
        }

        return $access;
    }
}
