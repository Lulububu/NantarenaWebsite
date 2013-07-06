<?php

namespace Nantarena\NewsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nantarena\NewsBundle\Entity\Comment;

class LoadCommentData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $comment = new Comment();
        $comment
            ->setAuthor($this->getReference('user-1'))
            ->setNews($this->getReference('news-1'))
            ->setContent('Une belle première news');
        $manager->persist($comment);

        $comment = new Comment();
        $comment
            ->setAuthor($this->getReference('user-2'))
            ->setNews($this->getReference('news-2'))
            ->setContent('Une belle seconde news');
        $manager->persist($comment);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 5;
    }
}