<?php

namespace Nantarena\ForumBundle\Twig;

use Nantarena\ForumBundle\Entity\Forum;
use Nantarena\ForumBundle\Entity\Thread;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ThreadExtension extends \Twig_Extension implements ContainerAwareInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    protected $container;

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('thread_path', array($this, 'getThreadPath')),
            new \Twig_SimpleFunction('thread_reply_path', array($this, 'getThreadReplyPath')),
            new \Twig_SimpleFunction('thread_create_path', array($this, 'getThreadCreatePath')),
            new \Twig_SimpleFunction('thread_delete_path', array($this, 'getThreadDeletePath')),
            new \Twig_SimpleFunction('thread_lock_path', array($this, 'getThreadLockPath')),
        );
    }

    public function getThreadPath(Thread $thread, $page = 1)
    {
        return $this->container->get('nantarena_forum.thread_manager')->getThreadPath($thread, $page);
    }

    public function getThreadReplyPath(Thread $thread)
    {
        return $this->container->get('nantarena_forum.thread_manager')->getReplyPath($thread);
    }

    public function getThreadCreatePath(Forum $forum)
    {
        return $this->container->get('nantarena_forum.thread_manager')->getCreatePath($forum);
    }

    public function getThreadLockPath(Thread $thread)
    {
        return $this->container->get('nantarena_forum.thread_manager')->getLockPath($thread);
    }

    public function getThreadDeletePath(Thread $thread)
    {
        return $this->container->get('nantarena_forum.thread_manager')->getDeletePath($thread);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'forum_thread_extension';
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}