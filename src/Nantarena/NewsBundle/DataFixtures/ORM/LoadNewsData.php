<?php

namespace Nantarena\NewsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nantarena\NewsBundle\Entity\News;

class LoadNewsData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $news = new News();
        $news
            ->setTitle('Première news')
            ->setCategory($this->getReference('category-1'))
            ->setContent('Une belle news numéro 1')
            ->setAuthor($this->getReference('user-1'))
            ->setState(News::STATE_PUBLISHED);
        $manager->persist($news);

        $this->addReference('news-1', $news);

        $news = new News();
        $news
            ->setTitle('Seconde news')
            ->setCategory($this->getReference('category-2'))
            ->setContent('Une belle news numéro 2')
            ->setAuthor($this->getReference('user-2'));
        $manager->persist($news);

        $this->addReference('news-2', $news);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 4;
    }
}