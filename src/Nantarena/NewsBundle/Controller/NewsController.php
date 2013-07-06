<?php

namespace Nantarena\NewsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Nantarena\NewsBundle\Entity\News;
use Nantarena\NewsBundle\Form\Type\NewsType;

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
        return array(
            'news' => $this->getDoctrine()->getRepository('NantarenaNewsBundle:News')->findAll(),
        );
    }

    /**
     * @Route("/{id}-{slug}", name="nantarena_site_news_show")
     * @Template()
     */
    public function showAction($id, News $news)
    {
        return array(
            'news' => $news,
        );
    }
}
