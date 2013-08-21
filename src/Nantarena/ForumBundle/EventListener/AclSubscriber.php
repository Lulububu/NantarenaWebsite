<?php

namespace Nantarena\ForumBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Nantarena\ForumBundle\Entity\Category;
use Nantarena\ForumBundle\Entity\Forum;
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
        } elseif ($entity instanceof Category) {
            $this->container->get('nantarena_forum.acl_manager')->createAclForCategory($entity);
        } elseif ($entity instanceof Forum) {
            $this->container->get('nantarena_forum.acl_manager')->createAclForForum($entity);
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
        } else if ($entity instanceof Category || $entity instanceof Forum) {
            $this->container->get('nantarena_forum.acl_manager')->deleteAcl($entity);
        }
    }

    /**
     * Cette méthode va simplement changer les permissions sur les Category et Forum
     * en supprimant les anciennes Acl et en insérant de nouvelles
     *
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof Category) {
            $this->container->get('nantarena_forum.acl_manager')->deleteAcl($entity);
            $this->container->get('nantarena_forum.acl_manager')->createAclForCategory($entity);
        } elseif ($entity instanceof Forum) {
            $this->container->get('nantarena_forum.acl_manager')->deleteAcl($entity);
            $this->container->get('nantarena_forum.acl_manager')->createAclForForum($entity);
        }
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array('postPersist', 'preRemove', 'postUpdate');
    }

    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}