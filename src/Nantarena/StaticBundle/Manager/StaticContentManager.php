<?php

namespace Nantarena\StaticBundle\Manager;

use Nantarena\StaticBundle\Entity\StaticContent;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * Class StaticContentManager
 *
 * Manager afin de manipuler le contenu statique du site de la Nantarena
 *
 * @package Nantarena\StaticBundle\Manager
 */
class StaticContentManager
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Routing\Router
     */
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function getStaticContentPath(StaticContent $content)
    {
        return $this->router->generate('nantarena_static_show', array(
            'slug' => $content->getSlug(),
        ));
    }

    public function getStaticContentLink($page)
    {
        return $this->router->generate('nantarena_static_show', array(
            'slug' =>$page,
        ));
    }

    public function getEditPath(StaticContent $content)
    {
        return $this->router->generate('nantarena_static_admin_edit', array(
            'id' => $content->getId(),
        ));
    }

    public function getDeletePath(StaticContent $content)
    {
        return $this->router->generate('nantarena_static_admin_delete', array(
            'id' => $content->getId(),
        ));
    }

    public function getCreatePath()
    {
        return $this->router->generate('nantarena_static_admin_create');
    }
}