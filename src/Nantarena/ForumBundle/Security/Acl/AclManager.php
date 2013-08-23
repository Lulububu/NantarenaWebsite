<?php

namespace Nantarena\ForumBundle\Security\Acl;

use Nantarena\ForumBundle\Entity\Category;
use Nantarena\ForumBundle\Entity\Forum;
use Nantarena\ForumBundle\Entity\Post;
use Nantarena\ForumBundle\Entity\Thread;
use Nantarena\SiteBundle\Security\Acl\Domain\GroupSecurityIdentity;
use Nantarena\UserBundle\Entity\Group;
use Symfony\Component\Security\Acl\Dbal\MutableAclProvider;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\RoleSecurityIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Model\MutableAclInterface;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class AclManager
 *
 * Service de gestion des Acl pour le forum
 *
 * @package Nantarena\ForumBundle\Security\Acl
 */
class AclManager
{
    /**
     * @var MutableAclProvider
     */
    protected $provider;

    /**
     * @var
     */
    protected $securityContext;

    /**
     * Constructeur
     *
     * @param MutableAclProvider $provider
     * @param SecurityContext    $securityContext
     */
    public function __construct(MutableAclProvider $provider, SecurityContext $securityContext)
    {
        $this->provider = $provider;
        $this->securityContext = $securityContext;
    }

    /**
     * Crée une Acl pour un Thread
     *
     * On donne ici accès OPERATOR au créateur du thread et aux modérateurs
     *
     * @param Thread $thread
     */
    public function createAclForThread(Thread $thread)
    {
        $userSecurity = $this->createUserSecurityIdentity($thread->getUser());
        $moderatorSecurity = $this->createRoleSecurityIdentity('ROLE_FORUM_MODERATE');

        $threadIdentity = $this->createObjectIdentity($thread);
        $acl = $this->createAcl($threadIdentity);
        $acl->insertObjectAce($userSecurity, MaskBuilder::MASK_EDIT);
        $acl->insertObjectAce($moderatorSecurity, MaskBuilder::MASK_OPERATOR);
        $this->updateAcl($acl);
    }

    /**
     * Crée une Acl pour un Post
     *
     * Ici aussi on donne accès au créateur du Post et aux modérateurs
     *
     * @param Post $post
     */
    public function createAclForPost(Post $post)
    {
        $userSecurity = $this->createUserSecurityIdentity($post->getUser());
        $moderatorSecurity = $this->createRoleSecurityIdentity('ROLE_FORUM_MODERATE');

        $postIdentity = $this->createObjectIdentity($post);
        $acl = $this->createAcl($postIdentity);
        $acl->insertObjectAce($userSecurity, MaskBuilder::MASK_EDIT);
        $acl->insertObjectAce($moderatorSecurity, MaskBuilder::MASK_OPERATOR);
        $this->updateAcl($acl);
    }

    /**
     * Crée une Acl pour un Forum
     *
     * @param Forum $forum
     */
    public function createAclForForum(Forum $forum)
    {
        $forumIdentity = $this->createObjectIdentity($forum);
        $acl = $this->createAcl($forumIdentity);
        $groups = $forum->getGroups();

        // aucun groupe = accès public
        if (0 === $groups->count()) {
            $acl->insertObjectAce($this->createRoleSecurityIdentity('IS_AUTHENTICATED_ANONYMOUSLY'), MaskBuilder::MASK_VIEW);
        } else {
            /** @var Group $group */
            foreach ($groups as $group) {
                $acl->insertObjectAce($this->createRoleSecurityIdentity('ROLE_GROUP_'.$group->getId()), MaskBuilder::MASK_VIEW);
            }
        }

        // Toujours veiller à donner accès au SUPER_ADMIN
        $acl->insertObjectAce($this->createRoleSecurityIdentity('ROLE_SUPER_ADMIN'), MaskBuilder::MASK_MASTER);

        $this->updateAcl($acl);
    }

    /**
     * Crée une Acl pour une category
     *
     * @param Category $category
     */
    public function createAclForCategory(Category $category)
    {
        $categoryIdentity = $this->createObjectIdentity($category);
        $acl = $this->createAcl($categoryIdentity);
        $groups = $category->getGroups();

        // aucun groupe = accès public
        if (0 === $groups->count()) {
            $acl->insertObjectAce($this->createRoleSecurityIdentity('IS_AUTHENTICATED_ANONYMOUSLY'), MaskBuilder::MASK_VIEW);
        } else {
            /** @var Group $group */
            foreach ($groups as $group) {
                $acl->insertObjectAce($this->createRoleSecurityIdentity('ROLE_GROUP_'.$group->getId()), MaskBuilder::MASK_VIEW);
            }
        }

        // Toujours veiller à donner accès au SUPER_ADMIN
        $acl->insertObjectAce($this->createRoleSecurityIdentity('ROLE_SUPER_ADMIN'), MaskBuilder::MASK_MASTER);

        $this->updateAcl($acl);
    }

    public function createUserSecurityIdentity(UserInterface $user)
    {
        return UserSecurityIdentity::fromAccount($user);
    }

    public function createRoleSecurityIdentity($role)
    {
        return new RoleSecurityIdentity($role);
    }

    public function createAcl($objectIdentity)
    {
        return $this->provider->createAcl($objectIdentity);
    }

    /**
     * Met à jour les informations en db
     *
     * @param MutableAclInterface $acl
     */
    public function updateAcl($acl)
    {
        $this->provider->updateAcl($acl);
    }

    /**
     * @param mixed $object
     * @return ObjectIdentity
     */
    public function createObjectIdentity($object)
    {
        return ObjectIdentity::fromDomainObject($object);
    }

    /**
     * @return \Symfony\Component\Security\Acl\Dbal\MutableAclProvider
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @return SecurityContext
     */
    public function getSecurityContext()
    {
        return $this->securityContext;
    }

    public function deleteAcl($object)
    {
        $this->provider->deleteAcl($this->createObjectIdentity($object));
    }

    public function getAclProvider()
    {
        return $this->provider;
    }
}
