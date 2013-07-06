<?php

namespace Nantarena\NewsBundle\Manager;

use Nantarena\NewsBundle\Entity\News;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class NewsManager
{
    /**
     * @var Router
     */
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function getNewsPath(News $news)
    {
        return $this->router->generate('nantarena_site_news_show', array(
            'id' => $news->getId(),
            'slug' => $news->getSlug(),
        ));
    }
}
