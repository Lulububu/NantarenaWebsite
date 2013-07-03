<?php

namespace Nantarena\UserBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Controller\RegistrationController as BaseController;


class RegistrationController extends BaseController
{
    public function registerAction(Request $request)
    {
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return new RedirectResponse($this->container->get('router')->generate('nantarena_site_home'));
        }

        return parent::registerAction($request);
    }

    public function checkEmailAction()
    {
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return new RedirectResponse($this->container->get('router')->generate('nantarena_site_home'));
        }

        return parent::checkEmailAction();
    }

    public function confirmAction(Request $request, $token)
    {
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return new RedirectResponse($this->container->get('router')->generate('nantarena_site_home'));
        }

        return parent::confirmAction($request, $token);
    }
}
