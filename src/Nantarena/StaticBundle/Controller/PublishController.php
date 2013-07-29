<?php

namespace Nantarena\StaticBundle\Controller;

use Nantarena\StaticBundle\Entity\StaticContent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class PublishController
 *
 * @package Nantarena\StaticBundle\Controller
 *
 * @Route("/admin/static")
 */
class PublishController extends Controller
{
    /**
     * @Route("/publish/{id}", name="nantarena_static_publish")
     */
    public function publishAction(StaticContent $content)
    {
        $em = $this->getDoctrine()->getManager();
        $content->setState(true);
        $em->flush();

        return $this->redirect($this->generateUrl('nantarena_static_admin_index'));
    }

    /**
     * @Route("/unpublish/{id}", name="nantarena_static_unpublish")
     */
    public function unpublishAction(StaticContent $content)
    {
        $em = $this->getDoctrine()->getManager();
        $content->setState(false);
        $em->flush();

        return $this->redirect($this->generateUrl('nantarena_static_admin_index'));
    }
}
