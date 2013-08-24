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

    public function findRecents($limit = 10)
    {
        $qb = $this->createQueryBuilder('t');

        $qb
            ->addSelect('t, p, u1, u2, f, c')
            ->join('t.forum', 'f')
            ->join('f.category', 'c')
            ->join('t.user', 'u1')
            ->join('t.posts', 'p')
            ->join('p.user', 'u2')
            ->addOrderBy('t.updateDate', 'desc');

        return array_slice($qb->getQuery()->getResult(), 0, $limit);
    }

    public function findUnreads(\DateTime $date)
    {
        $qb = $this->createQueryBuilder('t');

        $qb
            ->addSelect('t')
            ->andWhere('t.updateDate > :date')
            ->setParameter('date', $date);

        return $qb->getQuery()->getResult();
    }
}
