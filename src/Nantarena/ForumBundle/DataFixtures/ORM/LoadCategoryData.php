<?php

namespace Nantarena\ForumBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Nantarena\ForumBundle\Entity\Category;

class LoadCategoryData extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $category = new Category();
        $category->setName('Le Club Rézo');
        $category->setPosition(1);
        $this->addReference('category-club', $category);
        $manager->persist($category);

        $category = new Category();
        $category->setName('La Nantarena');
        $category->setPosition(2);
        $this->addReference('category-nantarena', $category);
        $manager->persist($category);

        $manager->flush();
    }
}