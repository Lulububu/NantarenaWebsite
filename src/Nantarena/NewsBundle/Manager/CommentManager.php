<?php

namespace Nantarena\NewsBundle\Manager;

use Nantarena\NewsBundle\Entity\Comment;
use Nantarena\NewsBundle\Entity\News;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class CommentManager
{
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function getCreateCommentPath(News $news)
    {
        return $this->router->generate('nantarena_news_comment_create', array(
            'id' => $news->getId(),
        ));
    }

    public function getDeleteCommentPath(Comment $comment)
    {
        return $this->router->generate('nantarena_news_comment_delete', array(
            'id' => $comment->getId(),
        ));
    }
}