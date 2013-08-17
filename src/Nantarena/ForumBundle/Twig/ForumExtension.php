<?php

namespace Nantarena\ForumBundle\Twig;

use Nantarena\ForumBundle\Entity\Forum;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ForumExtension extends \Twig_Extension implements ContainerAwareInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    protected $container;

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('forum_path', array($this, 'getForumPath')),
            new \Twig_SimpleFunction('forum_edit_path', array($this, 'getEditPath')),
            new \Twig_SimpleFunction('forum_create_path', array($this, 'getCreatePath')),
            new \Twig_SimpleFunction('forum_delete_path', array($this, 'getDeletePath')),
        );
    }

    public function getForumPath(Forum $forum)
    {
        return $this->container->get('nantarena_forum.forum_manager')->getForumPath($forum);
    }

    public function getDeletePath(Forum $forum)
    {
        return $this->container->get('nantarena_forum.forum_manager')->getDeletePath($forum);
    }

    public function getEditPath(Forum $forum)
    {
        return $this->container->get('nantarena_forum.forum_manager')->getEditPath($forum);
    }

    public function getCreatePath()
    {
        return $this->container->get('nantarena_forum.forum_manager')->getCreatePath();
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'forum_forum_extension';
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