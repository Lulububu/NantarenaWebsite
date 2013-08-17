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
            ->setUsername('admin')
            ->setEmail('admin@nantarena.net')
            ->setPlainPassword('admin')
            ->addGroup($this->getReference('group-1'))
            ->addGroup($this->getReference('group-3'))
            ->setEnabled(true);
        $manager->persist($user);

        $this->addReference('user-1', $user);

        $user = new User();
        $user
            ->setUsername('staff')
            ->setEmail('staff@nantarena.net')
            ->setPlainPassword('staff')
            ->addGroup($this->getReference('group-2'))
            ->addGroup($this->getReference('group-3'))
            // cet utilisateur est modérateur sur le forum
            ->addGroup($this->getReference('group-forum-moderate'))
            ->setEnabled(true);
        $manager->persist($user);

        $this->addReference('user-2', $user);

        $user = new User();
        $user
            ->setUsername('user')
            ->setEmail('user@nantarena.net')
            ->setPlainPassword('user')
            ->addGroup($this->getReference('group-3'))
            ->setEnabled(true);
        $manager->persist($user);

        $this->addReference('user-3', $user);

        $manager->flush();

        $user = new User();
        $user
            ->setUsername('demo')
            ->setEmail('demo@nantarena.net')
            ->setPlainPassword('demo')
            ->addGroup($this->getReference('group-3'))
            ->setEnabled(true);
        $manager->persist($user);

        $this->addReference('user-4', $user);

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
