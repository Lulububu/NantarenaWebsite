<?php

namespace Nantarena\NewsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nantarena\NewsBundle\Entity\Category;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $category = new Category();
        $category->setName('Categorie 1');
        $this->addReference('category-1', $category);
        $manager->persist($category);

        $category = new Category();
        $category->setName('Categorie 2');
        $this->addReference('category-2', $category);
        $manager->persist($category);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 3;
    }
}