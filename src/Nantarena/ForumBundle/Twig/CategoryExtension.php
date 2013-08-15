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
        );
    }

    public function getCategoryPath(Category $category)
    {
        return $this->container->get('nantarena_forum.category_manager')->getCategoryPath($category);
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