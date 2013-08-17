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
            'categoryId' => $thread->getForum()->getCategory()->getId(),
            'categorySlug' => $thread->getForum()->getCategory()->getSlug(),
            'forumId' => $thread->getForum()->getId(),
            'forumSlug' => $thread->getForum()->getSlug(),
            'id' => $thread->getId(),
            'slug' => $thread->getSlug(),
            'page' => $page,
        ));
    }

    public function getReplyPath(Thread $thread)
    {
        return $this->router->generate('nantarena_forum_post_reply', array(
            'categoryId' => $thread->getForum()->getCategory()->getId(),
            'categorySlug' => $thread->getForum()->getCategory()->getSlug(),
            'forumId' => $thread->getForum()->getId(),
            'forumSlug' => $thread->getForum()->getSlug(),
            'id' => $thread->getId(),
            'slug' => $thread->getSlug(),
        ));
    }

    public function getCreatePath(Forum $forum)
    {
        return $this->router->generate('nantarena_forum_thread_create', array(
            'categoryId' => $forum->getCategory()->getId(),
            'categorySlug' => $forum->getCategory()->getSlug(),
            'id' => $forum->getId(),
            'slug' => $forum->getSlug(),
        ));
    }

    public function getLockPath(Thread $thread)
    {
        return $this->router->generate('nantarena_forum_thread_lock', array(
            'categoryId' => $thread->getForum()->getCategory()->getId(),
            'categorySlug' => $thread->getForum()->getCategory()->getSlug(),
            'forumId' => $thread->getForum()->getId(),
            'forumSlug' => $thread->getForum()->getSlug(),
            'id' => $thread->getId(),
            'slug' => $thread->getSlug(),
        ));
    }

    public function getDeletePath(Thread $thread)
    {
        return $this->router->generate('nantarena_forum_thread_delete', array(
            'categoryId' => $thread->getForum()->getCategory()->getId(),
            'categorySlug' => $thread->getForum()->getCategory()->getSlug(),
            'forumId' => $thread->getForum()->getId(),
            'forumSlug' => $thread->getForum()->getSlug(),
            'id' => $thread->getId(),
            'slug' => $thread->getSlug(),
        ));
    }
}
