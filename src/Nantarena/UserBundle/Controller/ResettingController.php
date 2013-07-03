<?php

namespace Nantarena\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\ResettingController as BaseController;


class ResettingController extends BaseController
{
    public function requestAction()
    {
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return new RedirectResponse($this->container->get('router')->generate('nantarena_site_home'));
        }

        return parent::requestAction();
    }

    public function sendEmailAction(Request $request)
    {
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return new RedirectResponse($this->container->get('router')->generate('nantarena_site_home'));
        }

        return parent::sendEmailAction($request);
    }

    public function checkEmailAction()
    {
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return new RedirectResponse($this->container->get('router')->generate('nantarena_site_home'));
        }

        return parent::checkEmailAction();
    }

    public function resetAction(Request $request, $token)
    {
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return new RedirectResponse($this->container->get('router')->generate('nantarena_site_home'));
        }

        return parent::resetAction($request, $token);
    }
}
