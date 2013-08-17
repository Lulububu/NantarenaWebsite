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
            'category_id' => $forum->getCategory()->getId(),
            'category_slug' => $forum->getCategory()->getSlug(),
            'id' => $forum->getId(),
            'slug' => $forum->getSlug(),
        ));
    }

    public function getEditPath(Forum $forum)
    {
        return $this->router->generate('nantarena_forum_admin_forums_edit', array(
            'id' => $forum->getId(),
        ));
    }

    public function getDeletePath(Forum $forum)
    {
        return $this->router->generate('nantarena_forum_admin_forums_delete', array(
            'id' => $forum->getId(),
        ));
    }

    public function getCreatePath()
    {
        return $this->router->generate('nantarena_forum_admin_forums_create');
    }
}
