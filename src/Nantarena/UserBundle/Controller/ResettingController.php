<?php

namespace Nantarena\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\ResettingController as BaseController;


class ResettingController extends BaseController implements AnonymousOnlyController
{
}
