<?php

namespace Nantarena\BannerBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use Nantarena\BannerBundle\Entity\SponsorSlide;

class LoadBannerSponsorSlide extends AbstractFixture
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
<p>
    <a href="#" title="MSI">
        <img src="http://i.imgur.com/7v1tgYp.png" alt="MSI" />
    </a>
</p>
<h2>Partenaire de la Nantarena</h2>');

        $manager->persist($slide1);

        // Add one active header news
        $slide2 = new SponsorSlide();
        $slide2
            ->setActive(true)
            ->setContent('
<p>
    <a href="#" title="Roccat">
        <img src="http://i.imgur.com/S1A7ejG.jpg" alt="Roccat" />
    </a>
</p>
<p>
    <a href="#" title="Roccat">
        <img src="http://i.imgur.com/B62U2Tj.jpg" alt="Roccat" />
    </a>
</p>');


        $manager->persist($slide2);
        $manager->flush();
    }
}
