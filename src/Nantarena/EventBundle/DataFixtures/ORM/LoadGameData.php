<?php

namespace Nantarena\EventBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nantarena\EventBundle\Entity\Game;

class LoadGameData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $lol = new Game();
        $lol->setName('League of Legends');
        $lol->setPlatform('PC');
        $lol->setTeamCapacity(5);

        $csgo = new Game();
        $csgo->setName('Counter Strike: Global Offensive');
        $csgo->setPlatform('PC');
        $csgo->setTeamCapacity(5);

        $this->addReference('game-1', $lol);
        $this->addReference('game-2', $csgo);
        $manager->persist($lol);
        $manager->persist($csgo);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }
}
