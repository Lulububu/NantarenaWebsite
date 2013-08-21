<?php

namespace Nantarena\ForumBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Nantarena\ForumBundle\Entity\Category;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadCategoryData extends AbstractFixture implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function load(ObjectManager $manager)
    {
        $category1 = new Category();
        $category1->setName('Le Club Rézo');
        $category1->setPosition(1);
        $category1->addGroup($this->getReference('group-staffs'));
        $this->addReference('category-club', $category1);
        $manager->persist($category1);

        $category2 = new Category();
        $category2->setName('La Nantarena');
        $category2->setPosition(2);
        $this->addReference('category-nantarena', $category2);
        $manager->persist($category2);

        $manager->flush();
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
