<?php

namespace Nantarena\ForumBundle\Repository;

use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityRepository;

class ThreadRepository extends EntityRepository
{
    public function find($id, $lockMode = LockMode::NONE, $lockVersion = null)
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
}
