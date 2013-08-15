<?php

namespace Nantarena\ContactBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use Nantarena\ContactBundle\Entity\Category;

class LoadContactCategory extends AbstractFixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Add one active header news
        $cat = new Category();
        $cat
            ->setName('Defaut')
            ->setTag('default');

        $manager->persist($cat);

        $manager->flush();
    }
}
