<?php

namespace Nantarena\NewsBundle\Twig;

use Nantarena\NewsBundle\Entity\News;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class NewsExtension extends \Twig_Extension implements ContainerAwareInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    protected $container;

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('news_state', array($this, 'getNewsState')),
            new \Twig_SimpleFunction('news_path', array($this, 'getNewsPath')),
            new \Twig_SimpleFunction('news_edit_path', array($this, 'getEditPath')),
            new \Twig_SimpleFunction('news_delete_path', array($this, 'getDeletePath')),
        );
    }

    public function getNewsPath(News $news)
    {
        return $this->container->get('nantarena_news.news_manager')->getNewsPath($news);
    }

    public function getEditPath(News $news)
    {
        return $this->container->get('nantarena_news.news_manager')->getEditPath($news);
    }

    public function getDeletePath(News $news)
    {
        return $this->container->get('nantarena_news.news_manager')->getDeletePath($news);
    }

    public function getNewsState(News $news)
    {
        if (true == $news->getState()) {
            return $this->container->get('translator')->trans('news.state.published');
        } else {
            return $this->container->get('translator')->trans('news.state.unpublished');
        }
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'news_extension';
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