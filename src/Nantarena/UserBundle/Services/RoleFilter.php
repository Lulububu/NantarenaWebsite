<?php

namespace Nantarena\UserBundle\Services;


use Nantarena\UserBundle\Controller\AnonymousOnlyController;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class RoleFilter
{
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        /*
         * $controller passed can be either a class or a Closure. This is not usual in Symfony2 but it may happen.
         * If it is a class, it comes in array format
         */
        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof AnonymousOnlyController) {
            $event->setController(function() {
                return new RedirectResponse($this->router->generate('nantarena_site_home'));
            });
        }
    }
}
