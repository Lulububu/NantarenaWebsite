<?php

namespace Nantarena\ForumBundle\Repository;

use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class ForumRepository extends EntityRepository
{
    public function findWithJoins($id)
    {
        $qb = $this->createQueryBuilder('f');

        $qb
            ->addSelect('f, t, u, c')
            ->join('f.category', 'c')
            ->leftJoin('f.threads', 't', Join::WITH, 't.sticky = :sticky')
            ->leftJoin('t.user', 'u')
            ->andWhere('f.id = :id')
            ->setParameter('sticky', false)
            ->setParameter('id', $id);

        return $qb->getQuery()->getSingleResult();
    }
}
