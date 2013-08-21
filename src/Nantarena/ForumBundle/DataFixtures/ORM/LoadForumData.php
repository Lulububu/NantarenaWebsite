<?php

namespace Nantarena\ForumBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nantarena\ForumBundle\Entity\Forum;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadForumData extends AbstractFixture implements DependentFixtureInterface, ContainerAwareInterface
{
    /**
     * @var Container
     */
    private $container;

    public function load(ObjectManager $manager)
    {
        // catégorie Club

        $forum1 = new Forum();
        $forum1->setName('Discussions générales');
        $forum1->setPosition(1);
        $forum1->setCategory($this->getReference('category-club'));
        $forum1->addGroup($this->getReference('group-staffs'));
        $this->addReference('forum-club-general', $forum1);
        $manager->persist($forum1);

        $forum2 = new Forum();
        $forum2->setName('Comptes rendus réunions');
        $forum2->setPosition(2);
        $forum2->setCategory($this->getReference('category-club'));
        $forum2->addGroup($this->getReference('group-staffs'));
        $this->addReference('forum-club-compte', $forum2);
        $manager->persist($forum2);

        // categorie Nantarena

        $forum4 = new Forum();
        $forum4->setName('Discussions générales');
        $forum4->setPosition(1);
        $forum4->setCategory($this->getReference('category-nantarena'));
        $this->addReference('forum-nantarena-general', $forum4);
        $manager->persist($forum4);

        $forum5 = new Forum();
        $forum5->setName('Questions et réponses');
        $forum5->setPosition(2);
        $forum5->setCategory($this->getReference('category-nantarena'));
        $this->addReference('forum-nantarena-faq', $forum5);
        $manager->persist($forum5);

        $forum3 = new Forum();
        $forum3->setName('Remarques et suggestions');
        $forum3->setPosition(3);
        $forum3->setCategory($this->getReference('category-nantarena'));
        $this->addReference('forum-nantarena-remarques', $forum3);
        $manager->persist($forum3);

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return array('Nantarena\ForumBundle\DataFixtures\ORM\LoadCategoryData');
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
