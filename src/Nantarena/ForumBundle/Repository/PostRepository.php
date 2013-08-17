<?php

namespace Nantarena\ForumBundle\Repository;

use Doctrine\ORM\EntityRepository;

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
}
