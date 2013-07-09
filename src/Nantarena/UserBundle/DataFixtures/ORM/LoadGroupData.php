<?php

namespace Nantarena\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nantarena\UserBundle\Entity\Group;

class LoadGroupData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $adminsGroup = new Group('admins');
        $adminsGroup->addRole('ROLE_ADMIN');

        $usersGroup= new Group('users');
        $usersGroup->addRole('ROLE_USER');

        $this->addReference('group-1', $adminsGroup);
        $this->addReference('group-2', $usersGroup);

        $manager->persist($adminsGroup);
        $manager->persist($usersGroup);

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