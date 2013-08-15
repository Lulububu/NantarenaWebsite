<?php

namespace Nantarena\ForumBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nantarena\ForumBundle\Entity\Forum;

class LoadForumData extends AbstractFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // catégorie Club

        $forum = new Forum();
        $forum->setName('Discussions générales');
        $forum->setPosition(1);
        $forum->setCategory($this->getReference('category-club'));
        $this->addReference('forum-club-general', $forum);
        $manager->persist($forum);

        $forum = new Forum();
        $forum->setName('Comptes rendus réunions');
        $forum->setPosition(2);
        $forum->setCategory($this->getReference('category-club'));
        $this->addReference('forum-club-compte', $forum);
        $manager->persist($forum);

        // categorie Nantarena

        $forum = new Forum();
        $forum->setName('Discussions générales');
        $forum->setPosition(1);
        $forum->setCategory($this->getReference('category-nantarena'));
        $this->addReference('forum-nantarena-general', $forum);
        $manager->persist($forum);

        $forum = new Forum();
        $forum->setName('Questions et réponses');
        $forum->setPosition(2);
        $forum->setCategory($this->getReference('category-nantarena'));
        $this->addReference('forum-nantarena-faq', $forum);
        $manager->persist($forum);

        $forum = new Forum();
        $forum->setName('Remarques et suggestions');
        $forum->setPosition(3);
        $forum->setCategory($this->getReference('category-nantarena'));
        $this->addReference('forum-nantarena-remarques', $forum);
        $manager->persist($forum);

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
        return array('Nantarena\ForumBundle\DataFixtures\ORM\LoadCategoryData');
    }
}