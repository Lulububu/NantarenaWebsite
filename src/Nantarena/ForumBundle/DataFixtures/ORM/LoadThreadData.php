<?php

namespace Nantarena\ForumBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nantarena\ForumBundle\Entity\Thread;

class LoadThreadData extends AbstractFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // forum Discussion Club

        $thread = new Thread();
        $thread->setForum($this->getReference('forum-club-general'));
        $thread->setUser($this->getReference('user-1'));
        $thread->setName('Topic discussions club');
        $this->addReference('thread-1', $thread);
        $manager->persist($thread);

        // forum Nantarena FAQ

        $thread = new Thread();
        $thread->setForum($this->getReference('forum-nantarena-faq'));
        $thread->setUser($this->getReference('user-2'));
        $thread->setName('Une question par exemple');
        $this->addReference('thread-2', $thread);
        $manager->persist($thread);

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    function getDependencies()
    {
        return array(
            'Nantarena\ForumBundle\DataFixtures\ORM\LoadCategoryData'
        );
    }
}