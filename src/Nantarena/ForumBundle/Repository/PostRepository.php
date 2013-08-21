<?php

namespace Nantarena\ForumBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Nantarena\ForumBundle\Entity\Thread;

class PostRepository extends EntityRepository
{
    public function findWithJoins($id)
    {
        $qb = $this->createQueryBuilder('p');

        $qb
            ->addSelect('p, t, f, c')
            ->join('p.thread', 't')
            ->join('t.forum', 'f')
            ->join('f.category', 'c')
            ->andWhere('p.id = :id')
            ->setParameter('id', $id);

        return $qb->getQuery()->getSingleResult();
    }

    public function findLastPostsOrderedByIdDesc(Thread $thread, $limit = 3)
    {
        $qb = $this->createQueryBuilder('p');

        $qb
            ->addSelect('p, u')
            ->join('p.thread', 't')
            ->join('p.user', 'u')
            ->andWhere('t.id = :id')
            ->setParameter('id', $thread->getId())
            ->addOrderBy('p.id', 'desc')
            ->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }
}
