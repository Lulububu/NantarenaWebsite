<?php

namespace Nantarena\ForumBundle\Repository;

use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityRepository;

class ForumRepository extends EntityRepository
{
    public function find($id, $lockMode = LockMode::NONE, $lockVersion = null)
    {
        $qb = $this->createQueryBuilder('f');

        $qb
            ->addSelect('f, t, u, c')
            ->join('f.category', 'c')
            ->leftJoin('f.threads', 't')
            ->leftJoin('t.user', 'u')
            ->andWhere('f.id = :id')
            ->setParameter('id', $id);

        return $qb->getQuery()->getSingleResult();
    }
}
