<?php

namespace Nantarena\ForumBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Nantarena\ForumBundle\Entity\ReadStatus;
use Nantarena\UserBundle\Entity\User;

class ReadStatusRepository extends EntityRepository
{
    /**
     * @param User $user
     * @return ReadStatus
     */
    public function findOneByUser(User $user)
    {
        $qb = $this->createQueryBuilder('r');

        $qb
            ->addSelect('r, t, p')
            ->leftJoin('r.threads', 't')
            ->leftJoin('t.posts', 'p')
            ->andWhere('r.user = :id')
            ->setParameter('id', $user);

        return $qb->getQuery()->getSingleResult();
    }
}
