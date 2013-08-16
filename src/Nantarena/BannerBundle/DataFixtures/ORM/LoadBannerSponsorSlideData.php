<?php

namespace Nantarena\BannerBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use Nantarena\BannerBundle\Entity\SponsorSlide;

class LoadBannerSponsorSlideData extends AbstractFixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Add one active header news
        $slide1 = new SponsorSlide();
        $slide1
            ->setActive(true)
            ->setContent('
<p style="text-align:center"><a href="#" title="MSI"><img alt="MSI" src="http://i.imgur.com/7v1tgYp.png" /> </a></p>
<h2 style="text-align:center">Partenaire de la Nantarena</h2>
');

        $manager->persist($slide1);

        // Add one active header news
        $slide2 = new SponsorSlide();
        $slide2
            ->setActive(true)
            ->setContent('
<p style="text-align:center"><a href="#" title="Roccat"><img alt="Roccat" src="http://i.imgur.com/S1A7ejG.jpg" /> </a></p>
<p style="text-align:center"><a href="#" title="Roccat"><img alt="Roccat" src="http://i.imgur.com/B62U2Tj.jpg" /> </a></p>
');


        $manager->persist($slide2);
        $manager->flush();
    }
}
