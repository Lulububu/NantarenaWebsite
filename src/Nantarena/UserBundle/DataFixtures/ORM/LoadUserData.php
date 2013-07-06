<?php

namespace Nantarena\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nantarena\UserBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user
            ->setUsername('Testeur1')
            ->setEmail('testeur1@nantarena.net')
            ->setPlainPassword('testeur1')
            ->addGroup($this->getReference('group-1'))
            ->setEnabled(true);
        $manager->persist($user);

        $this->addReference('user-1', $user);

        $user = new User();
        $user
            ->setUsername('Testeur2')
            ->setEmail('testeur2@nantarena.net')
            ->setPlainPassword('testeur2')
            ->addGroup($this->getReference('group-2'))
            ->setEnabled(true);
        $manager->persist($user);

        $this->addReference('user-2', $user);

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