<?php

namespace Nantarena\EventBundle\Controller\Admin;

use Doctrine\ORM\EntityRepository;
use Nantarena\EventBundle\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class EntriesController
 *
 * @package Nantarena\EventBundle\Controller\Admin
 *
 * @Route("/admin/event/entries")
 */
class EntriesController extends Controller
{
    /**
     * @Route("/{slug}", name="nantarena_event_admin_entries",
     *    defaults={"slug" = null}
     * )
     * @Template()
     */
    public function listAction(Request $request, Event $event = null)
    {
        $db = $this->getDoctrine();

        if (null === $event) {
            if (null === ($event = $db->getRepository('NantarenaEventBundle:Event')->findNext()))
                return array();
        }

        $form = $this->createEventChoiceForm($event)->handleRequest($request);

        if ($form->isValid()) {
            $e = $form->get('event')->getData();
            return $this->redirect($this->generateUrl('nantarena_event_admin_entries', array(
                'slug' => $e->getSlug()
            )));
        }

        return array(
            'entries' => $db->getRepository('NantarenaEventBundle:Entry')->findByEvent($event),
            'form' => $form->createView()
        );
    }

    private function createEventChoiceForm(Event $event)
    {
        return $this->createFormBuilder(array('event' => $event))
            ->add('event', 'entity', array(
                'class' => 'NantarenaEventBundle:Event',
                'property' => 'name',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('e')
                        ->orderBy('e.startDate', 'DESC');
                }
            ))
            ->setMethod('POST')
            ->getForm();
    }
}
