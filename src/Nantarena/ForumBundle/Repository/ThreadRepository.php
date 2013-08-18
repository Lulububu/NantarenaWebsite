<?php

namespace Nantarena\ForumBundle\Repository;

use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class ThreadRepository extends EntityRepository
{
    public function findWithJoins($id)
    {
        $qb = $this->createQueryBuilder('t');

        $qb
            ->addSelect('t, c, u, p, u2, f')
            ->join('t.forum', 'f')
            ->join('f.category', 'c')
            ->join('t.user', 'u')
            ->join('t.posts', 'p')
            ->join('p.user', 'u2')
            ->andWhere('t.id = :id')
            ->setParameter('id', $id);

        return $qb->getQuery()->getSingleResult();
    }

    public function findBySticky($forumId, $sticky = false)
    {
        $qb = $this->createQueryBuilder('t');

        $qb
            ->addSelect('t, u, p, u2, f')
            ->join('t.forum', 'f', Join::WITH, 'f.id = :id')
            ->join('t.user', 'u')
            ->join('t.posts', 'p')
            ->join('p.user', 'u2')
            ->andWhere('t.sticky = :sticky')
            ->setParameter('id', $forumId)
            ->setParameter('sticky', $sticky);

        return $qb->getQuery()->getResult();
    }
}
