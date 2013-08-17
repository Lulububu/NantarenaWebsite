<?php

namespace Nantarena\ForumBundle\Twig;

use Nantarena\ForumBundle\Entity\Post;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PostExtension extends \Twig_Extension implements ContainerAwareInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    protected $container;

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('post_edit_path', array($this, 'getEditPath')),
            new \Twig_SimpleFunction('post_delete_path', array($this, 'getDeletePath')),
        );
    }

    public function getEditPath(Post $post)
    {
        return $this->container->get('nantarena_forum.post_manager')->getEditPath($post);
    }

    public function getDeletePath(Post $post)
    {
        return $this->container->get('nantarena_forum.post_manager')->getDeletePath($post);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'forum_post_extension';
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