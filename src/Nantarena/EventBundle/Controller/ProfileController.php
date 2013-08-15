<?php

namespace Nantarena\EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class ProfileController
 *
 * @package Nantarena\EventBundle\Controller
 *
 */
class ProfileController extends Controller
{
    /**
     * @Template()
     */
    public function indexAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();

        $em = $this->get('doctrine')->getManager();
        $event = $em->getRepository('NantarenaEventBundle:Event')->findNext();

        return array(
            'entries' => $user->getEntries(),
            'nextEvent' => $event
        );
    }
}
