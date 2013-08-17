<?php

namespace Nantarena\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/forum")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $categories = $this->getDoctrine()->getRepository('NantarenaForumBundle:Category')->findAllWithForums();

        $this->get('nantarena_site.breadcrumb')->push(
            $this->get('translator')->trans('forum.index.title'),
            $this->generateUrl('nantarena_forum_default_index')
        );

        return array(
            'categories' => $categories,
        );
    }
}
