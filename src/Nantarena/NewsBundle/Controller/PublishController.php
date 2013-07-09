<?php

namespace Nantarena\NewsBundle\Controller;

use Nantarena\NewsBundle\Entity\News;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PublishController extends Controller
{
    /**
     * @Route("/publish/{state}/{id}", name="nantarena_news_publish")
     */
    public function publishAction($state, News $news)
    {
        $em = $this->getDoctrine()->getManager();

        if ('published' === $state) {
            $news->setState(true);
            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('news.publish.flash_success'));
        } else {
            $news->setState(false);
            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('news.unpublish.flash_success'));
        }

        $em->persist($news);
        $em->flush();

        return $this->redirect($this->generateUrl('nantarena_news_admin_index'));
    }
}