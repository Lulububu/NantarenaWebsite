<?php

namespace Nantarena\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class NantarenaUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
