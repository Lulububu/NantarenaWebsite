<?php

namespace Nantarena\ForumBundle\Manager;

use Nantarena\ForumBundle\Entity\Forum;
use Nantarena\ForumBundle\Entity\Thread;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class ThreadManager
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Routing\Router
     */
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function getThreadPath(Thread $thread, $page = 1)
    {
        return $this->router->generate('nantarena_forum_thread_show', array(
            'category_id' => $thread->getForum()->getCategory()->getId(),
            'category_slug' => $thread->getForum()->getCategory()->getSlug(),
            'forum_id' => $thread->getForum()->getId(),
            'forum_slug' => $thread->getForum()->getSlug(),
            'id' => $thread->getId(),
            'slug' => $thread->getSlug(),
            'page' => $page,
        ));
    }

    public function getReplyPath(Thread $thread)
    {
        return $this->router->generate('nantarena_forum_post_reply', array(
            'category_id' => $thread->getForum()->getCategory()->getId(),
            'category_slug' => $thread->getForum()->getCategory()->getSlug(),
            'forum_id' => $thread->getForum()->getId(),
            'forum_slug' => $thread->getForum()->getSlug(),
            'id' => $thread->getId(),
            'slug' => $thread->getSlug(),
        ));
    }

    public function getCreatePath(Forum $forum)
    {
        return $this->router->generate('nantarena_forum_thread_create', array(
            'category_id' => $forum->getCategory()->getId(),
            'category_slug' => $forum->getCategory()->getSlug(),
            'id' => $forum->getId(),
            'slug' => $forum->getSlug(),
        ));
    }

    public function getLockPath(Thread $thread)
    {
        return $this->router->generate('nantarena_forum_thread_lock', array(
            'id' => $thread->getId(),
        ));
    }

    public function getDeletePath(Thread $thread)
    {
        return $this->router->generate('nantarena_forum_thread_delete', array(
            'id' => $thread->getId(),
        ));
    }

    public function getMovePath(Thread $thread)
    {
        return $this->router->generate('nantarena_forum_thread_move', array(
            'id' => $thread->getId(),
        ));
    }
}
