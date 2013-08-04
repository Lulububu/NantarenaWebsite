<?php

namespace Nantarena\BannerBundle\Manager;

use Nantarena\BannerBundle\Entity\HeaderNews;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * Class HeaderNewsManager
 *
 * @package Nantarena\BannerBundle\Manager
 */
class HeaderNewsManager
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Routing\Router
     */
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function getHeaderNewsPath(HeaderNews $content)
    {
        return $this->router->generate('nantarena_banner_news_index', array(
            'slug' => $content->getSlug(),
        ));
    }

    public function getEditPath(HeaderNews $content)
    {
        return $this->router->generate('nantarena_banner_news_edit', array(
            'id' => $content->getId(),
        ));
    }

    public function getDeletePath(HeaderNews $content)
    {
        return $this->router->generate('nantarena_banner_news_delete', array(
            'id' => $content->getId(),
        ));
    }

    public function getCreatePath()
    {
        return $this->router->generate('nantarena_banner_news_create');
    }
}