<?php

namespace Nantarena\ForumBundle\Manager;

use Nantarena\ForumBundle\Entity\Forum;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class ForumManager
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Routing\Router
     */
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function getForumPath(Forum $forum)
    {
        return $this->router->generate('nantarena_forum_forum_index', array(
            'categoryId' => $forum->getCategory()->getId(),
            'categorySlug' => $forum->getCategory()->getSlug(),
            'id' => $forum->getId(),
            'slug' => $forum->getSlug(),
        ));
    }
}
