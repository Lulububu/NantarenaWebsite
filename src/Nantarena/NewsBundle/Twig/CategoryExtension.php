<?php

namespace Nantarena\NewsBundle\Twig;

use Nantarena\NewsBundle\Entity\Category;
use Nantarena\NewsBundle\Entity\News;
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
            new \Twig_SimpleFunction('category_path', array($this, 'getCategoryPath')),
            new \Twig_SimpleFunction('category_edit_path', array($this, 'getEditPath')),
            new \Twig_SimpleFunction('category_delete_path', array($this, 'getDeletePath')),
        );
    }

    public function getCategoryPath(Category $category)
    {
        return $this->container->get('nantarena_news.category_manager')->getCategoryPath($category);
    }

    public function getEditPath(Category $category)
    {
        return $this->container->get('nantarena_news.category_manager')->getEditPath($category);
    }

    public function getDeletePath(Category $category)
    {
        return $this->container->get('nantarena_news.category_manager')->getDeletePath($category);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'category_extension';
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