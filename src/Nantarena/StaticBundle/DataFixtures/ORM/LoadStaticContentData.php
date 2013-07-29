<?php

namespace Nantarena\StaticBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Nantarena\StaticBundle\Entity\StaticContent;

class LoadStaticContentData extends AbstractFixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $example = new StaticContent();
        $example
            ->setState(true)
            ->setTitle('Une page statique exemple')
            ->setContent('Bienvenue sur la page exemple !');

        $manager->persist($example);
        $manager->flush();
    }
}
