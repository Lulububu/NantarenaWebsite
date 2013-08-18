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
        $page = new StaticContent();
        $page
            ->setState(true)
            ->setTitle('Une page statique exemple')
            ->setContent('Bienvenue sur la page exemple !');
        $manager->persist($page);

        $page = new StaticContent();
        $page
            ->setState(true)
            ->setTitle('Les tournois')
            ->setContent('Page de présentation des tournois à la Nantarena');
        $manager->persist($page);

        $page = new StaticContent();
        $page
            ->setState(true)
            ->setTitle('Présentation')
            ->setContent('Page de présentation de la Nantarena');
        $manager->persist($page);

        $page = new StaticContent();
        $page
            ->setState(true)
            ->setTitle('Informations pratiques')
            ->setContent('Page des informations pratiques');
        $manager->persist($page);

        $page = new StaticContent();
        $page
            ->setState(true)
            ->setTitle('Où sommes-nous ?')
            ->setContent('Page de localisation de la Nantarena');
        $manager->persist($page);

        $page = new StaticContent();
        $page
            ->setState(true)
            ->setTitle('Nos partenaires')
            ->setContent('Page de nos partenaires');
        $manager->persist($page);

        $page = new StaticContent();
        $page
            ->setState(true)
            ->setTitle('Qui sommes-nous ?')
            ->setContent('Page pour nous présenter');
        $manager->persist($page);

        $page = new StaticContent();
        $page
            ->setState(true)
            ->setTitle('Presse')
            ->setContent('Page relative à la presse');
        $manager->persist($page);

        $manager->flush();
    }
}
