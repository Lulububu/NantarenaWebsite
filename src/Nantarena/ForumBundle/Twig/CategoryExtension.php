<?php

namespace Nantarena\ForumBundle\Twig;

use Nantarena\ForumBundle\Entity\Category;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CategoryExtension extends \Twig_Extension implements ContainerAwareInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    protected $container;

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('forum_category_path', array($this, 'getCategoryPath')),
            new \Twig_SimpleFunction('forum_category_delete_path', array($this, 'getDeletePath')),
            new \Twig_SimpleFunction('forum_category_edit_path', array($this, 'getEditPath')),
            new \Twig_SimpleFunction('forum_category_create_path', array($this, 'getCreatePath')),
        );
    }

    public function getCategoryPath(Category $category)
    {
        return $this->container->get('nantarena_forum.category_manager')->getCategoryPath($category);
    }

    public function getDeletePath(Category $category)
    {
        return $this->container->get('nantarena_forum.category_manager')->getDeletePath($category);
    }

    public function getEditPath(Category $category)
    {
        return $this->container->get('nantarena_forum.category_manager')->getEditPath($category);
    }

    public function getCreatePath()
    {
        return $this->container->get('nantarena_forum.category_manager')->getCreatePath();
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'forum_category_extension';
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