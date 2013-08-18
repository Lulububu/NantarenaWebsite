<?php

namespace Nantarena\ForumBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Nantarena\ForumBundle\Entity\Post;
use Nantarena\ForumBundle\Entity\Thread;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AclSubscriber implements EventSubscriber, ContainerAwareInterface
{
    /**
     * @var Container
     */
    private $container;

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof Thread) {
            $this->container->get('nantarena_forum.acl_manager')->createAclForThread($entity);
        } elseif ($entity instanceof Post) {
            $this->container->get('nantarena_forum.acl_manager')->createAclForPost($entity);
        }
    }

    /**
     * Automatise la suppression des Acl lorsque l'on supprime un post ou topic
     *
     * @param LifecycleEventArgs $args
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof Thread || $entity instanceof Post) {
            $this->container->get('nantarena_forum.acl_manager')->deleteAcl($entity);
        }
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array('postPersist', 'preRemove');
    }

    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}