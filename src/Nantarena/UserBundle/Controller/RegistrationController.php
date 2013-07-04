<?php

namespace Nantarena\UserBundle\Controller;

use Nantarena\UserBundle\Controller\AnonymousOnlyController;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Controller\RegistrationController as BaseController;


class RegistrationController extends BaseController implements AnonymousOnlyController
{
}
