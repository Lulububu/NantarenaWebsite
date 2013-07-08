<?php

namespace Nantarena\AdminBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class DashboardCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {

        if (!$container->hasDefinition('nantarena_admin.dashboard_service')) {
            return;
        }

        $dashboard = $container->getDefinition('nantarena_admin.dashboard_service');
        $taggedServices = $container->findTaggedServiceIds('nantarena_admin.dashboard');

        foreach ($taggedServices as $id => $attributes) {
            $dashboard->addMethodCall(
                'addModule',
                array(new Reference($id))
            );
        }
    }
}
