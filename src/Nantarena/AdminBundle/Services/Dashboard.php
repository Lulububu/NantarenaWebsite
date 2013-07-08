<?php

namespace Nantarena\AdminBundle\Services;


use Nantarena\AdminBundle\Controller\DashboardInterface;

class Dashboard
{
    private $modules;

    public function __construct()
    {
        $this->modules = array();
    }

    public function addModule(DashboardInterface $module)
    {
        $this->modules[] = $module;
    }

    public function getModules()
    {
        return $this->modules;
    }
}
