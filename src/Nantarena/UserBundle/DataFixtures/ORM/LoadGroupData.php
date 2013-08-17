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
        $adminsGroup = new Group('Administrateurs');
        $adminsGroup->addRole('ROLE_SUPER_ADMIN');

        $staffGroup = new Group('Staff');
        $staffGroup->addRole('ROLE_USER_ADMIN_USERS');
        // donne accès aux parties reservées au staff
        $staffGroup->addRole('ROLE_STAFF_FORUM');

        $usersGroup = new Group('Membres');
        $usersGroup->addRole('ROLE_USER');
        $usersGroup->setDefault(true);

        $moderatorsGroup = new Group('Modérateur');
        $moderatorsGroup->addRole('ROLE_FORUM_MODERATE');

        $this->addReference('group-1', $adminsGroup);
        $this->addReference('group-2', $staffGroup);
        $this->addReference('group-3', $usersGroup);
        $this->addReference('group-forum-moderate', $moderatorsGroup);

        $manager->persist($adminsGroup);
        $manager->persist($staffGroup);
        $manager->persist($usersGroup);
        $manager->persist($moderatorsGroup);

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
