<?php

namespace Nantarena\AdminBundle;

use Nantarena\AdminBundle\DependencyInjection\Compiler\DashboardCompilerPass;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class NantarenaAdminBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new DashboardCompilerPass());
    }
}
