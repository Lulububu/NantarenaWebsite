<?php

namespace Nantarena\StaticBundle\Controller;

use Nantarena\StaticBundle\Entity\StaticContent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class StaticController extends Controller
{
    //@Cache(expires="tomorrow", public="true")
    /**
     * @Route("/{slug}", name="nantarena_static_show")
     * @Template()
     */
    public function showAction(StaticContent $content)
    {
        // Ici, c'est important de jeter une 404 quand la page n'a pas été publiée
        // afin d'éviter que les gens savent qu'une page existe réellement
        if ($content->getState() === StaticContent::STATE_UNPUBLISHED) {
            if (!$this->get('security.context')->isGranted('ROLE_STATIC_ADMIN')) {
                throw $this->createNotFoundException();
            }
        }

        return array(
            'content' => $content,
        );
    }
}
