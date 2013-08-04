<?php

namespace Nantarena\EventBundle\Controller;

use Nantarena\EventBundle\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class EventController
 *
 * @package Nantarena\EventBundle\Controller
 *
 * @Route("/event")
 */
class EventController extends Controller
{
    /**
     * @Route("/{slug}", name="nantarena_event_show")
     * @Template()
     */
    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('NantarenaEventBundle:Event')->findOneShow($slug);

        return array(
            'event' => $event,
        );
    }
}
