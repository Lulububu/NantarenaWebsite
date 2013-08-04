<?php

namespace Nantarena\BannerBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use Nantarena\BannerBundle\Entity\HeaderNews;

class LoadBannerHeaderNews extends AbstractFixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Add one active header news
        $example = new HeaderNews();
        $example
            ->setActive(true)
            ->setContent('<p>Pour votre divertissement !</p><img alt="Nantarena" src="http://www.nantarena.net/sites/default/files/logo.png" >');

        $manager->persist($example);
        $manager->flush();
    }
}
