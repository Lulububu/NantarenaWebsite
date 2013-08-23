<?php

namespace Nantarena\ForumBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;
use Nantarena\ForumBundle\Entity\ReadStatus;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class ReadStatusSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param InteractiveLoginEvent $event
     */
    public function postLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();

        // Crée l'entrée ReadStatus
        try {
            $status = $this->em->getRepository('NantarenaForumBundle:ReadStatus')->findOneByUser($user);
        } catch (NoResultException $e) {
            $status = new ReadStatus();
            $status
                ->setUser($user);

            // persist et flush du status
            $this->em->persist($status);
            $this->em->flush();
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
            'security.interactive_login' => 'postLogin',
        );
    }
}