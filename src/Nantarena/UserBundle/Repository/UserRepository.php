<?php

namespace Nantarena\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class UserRepository
 *
 * @package Nantarena\UserBundle\Repository
 */
class UserRepository extends EntityRepository
{
    public function findAllWithGroups()
    {
        return $this->createQueryBuilder('u')
            ->leftJoin('u.groups', 'g')
            ->addSelect('g')
            ->getQuery()
            ->getResult();
    }
}
