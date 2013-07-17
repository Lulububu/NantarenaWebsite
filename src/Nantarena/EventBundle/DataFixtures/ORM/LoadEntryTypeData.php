<?php

namespace Nantarena\EventBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nantarena\EventBundle\Entity\EntryType;

class LoadEntryTypeData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $player = new EntryType();
        $player->setName('Joueur');

        $cheerleader = new EntryType();
        $cheerleader->setName('Manager');

        $coverage = new EntryType();
        $coverage->setName('Coverage');

        $this->addReference('entrytype-1', $player);
        $this->addReference('entrytype-2', $cheerleader);
        $this->addReference('entrytype-3', $coverage);

        $manager->persist($player);
        $manager->persist($cheerleader);
        $manager->persist($coverage);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }
}
