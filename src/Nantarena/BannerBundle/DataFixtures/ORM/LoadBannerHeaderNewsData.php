<?php

namespace Nantarena\BannerBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use Nantarena\BannerBundle\Entity\HeaderNews;

class LoadBannerHeaderNewsData extends AbstractFixture
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
            ->setContent('
<p style="text-align:center">Pour votre divertissement !</p>
<p style="text-align:center"><img alt="Nantarena" src="http://www.nantarena.net/sites/default/files/logo.png" /></p>
');

        $manager->persist($example);
        $manager->flush();
    }
}
