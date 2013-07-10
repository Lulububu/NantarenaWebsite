<?php

namespace Nantarena\NewsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Nantarena\NewsBundle\Entity\News;
use Nantarena\NewsBundle\Form\Type\CommentType;

/**
 * Class NewsController
 *
 * @package Nantarena\NewsBundle\Controller
 *
 * @Route("/news")
 */
class NewsController extends Controller
{
    /**
     * @Route("/", name="nantarena_news_index")
     * @Template()
     */
    public function indexAction()
    {
        $newsRepository = $this->getDoctrine()->getRepository('NantarenaNewsBundle:News');
        $page = $this->getRequest()->get('page', 1);
        $limit = 5;
        $offset = ($page - 1) * 5;

        return array(
            'news' => $newsRepository->findAllPublished($limit, $offset),
            'count' => ceil($newsRepository->countAllPublished() / 5),
            'page' => $page,
        );
    }

    /**
     * @Route("/{id}-{slug}", name="nantarena_news_show")
     * @Template()
     */
    public function showAction(News $news)
    {
        if (News::STATE_UNPUBLISHED === $news->getState()) {
            return $this->redirect($this->generateUrl('nantarena_news_index'));
        }

        $form = $this->createForm(new CommentType(), null, array(
            'action' => $this->get('nantarena_news.comment_manager')->getCreateCommentPath($news),
            'method' => 'POST',
        ));

        return array(
            'news' => $news,
            'form' => $form->createView(),
        );
    }
}
