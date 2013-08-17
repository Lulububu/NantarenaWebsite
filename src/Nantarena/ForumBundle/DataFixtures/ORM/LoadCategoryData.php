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
        $this->addReference('category-club', $category1);
        $manager->persist($category1);

        $category2 = new Category();
        $category2->setName('La Nantarena');
        $category2->setPosition(2);
        $this->addReference('category-nantarena', $category2);
        $manager->persist($category2);

        $manager->flush();

        // Acl sur la catégorie Le Club Rézo
        $this->container->get('nantarena_forum.acl_manager')->createAclForCategory($category1, array(
            'ROLE_GROUP_'.$this->getReference('group-staffs')->getId()
        ));

        // Acl sur la catégorie La Nantarena, on omet le role car on désire qu'elle soit accessible
        // par les anonymes
        $this->container->get('nantarena_forum.acl_manager')->createAclForCategory($category2);
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
