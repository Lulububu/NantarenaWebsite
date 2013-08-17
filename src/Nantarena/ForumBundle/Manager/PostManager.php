<?php

namespace Nantarena\ForumBundle\Manager;

use Nantarena\ForumBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class PostManager
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Routing\Router
     */
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function getEditPath(Post $post)
    {
        return $this->router->generate('nantarena_forum_post_edit', array(
            'id' => $post->getId(),
        ));
    }

    public function getDeletePath(Post $post)
    {
        return $this->router->generate('nantarena_forum_post_delete', array(
            'id' => $post->getId(),
        ));
    }
}