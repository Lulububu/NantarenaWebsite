<?php

namespace Nantarena\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $categories = $this->getDoctrine()->getRepository('NantarenaForumBundle:Category')->findAllWithForum();

        $this->get('nantarena_site.breadcrumb')->push(
            $this->get('translator')->trans('forum.index.title'),
            $this->generateUrl('nantarena_forum_default_index')
        );

        return array(
            'categories' => $categories,
        );
    }
}
