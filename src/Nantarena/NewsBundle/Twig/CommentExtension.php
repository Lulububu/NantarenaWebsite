<?php

namespace Nantarena\NewsBundle\Twig;

use Nantarena\NewsBundle\Entity\Comment;
use Nantarena\NewsBundle\Entity\News;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CommentExtension extends \Twig_Extension implements ContainerAwareInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    protected $container;

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('comment_create_path', array($this, 'getCreateCommentPath')),
            new \Twig_SimpleFunction('comment_delete_path', array($this, 'getDeleteCommentPath')),
        );
    }

    public function getCreateCommentPath(News $news)
    {
        return $this->container->get('nantarena_news.comment_manager')->getCreateCommentPath($news);
    }

    public function getDeleteCommentPath(Comment $comment)
    {
        return $this->container->get('nantarena_news.comment_manager')->getDeleteCommentPath($comment);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'comment_extension';
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