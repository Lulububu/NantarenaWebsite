<?php

namespace Nantarena\NewsBundle\Manager;

use Nantarena\NewsBundle\Entity\News;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * Class NewsManager
 *
 * Contient l'essentiel des utilitaires pour gérer les news
 *
 * @package Nantarena\NewsBundle\Manager
 */
class NewsManager
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Routing\Router
     */
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function getNewsPath(News $news)
    {
        return $this->router->generate('nantarena_news_show', array(
            'id' => $news->getId(),
            'slug' => $news->getSlug(),
        ));
    }

    public function getEditPath(News $news)
    {
        return $this->router->generate('nantarena_news_admin_edit', array(
            'id' => $news->getId(),
        ));
    }

    public function getDeletePath(News $news)
    {
        return $this->router->generate('nantarena_news_admin_delete', array(
            'id' => $news->getId(),
        ));
    }

    public function getCreatePath()
    {
        return $this->router->generate('nantarena_news_admin_create');
    }
}
