<?php

namespace Nantarena\NewsBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Nantarena\NewsBundle\Entity\Category;
use Nantarena\NewsBundle\Entity\News;

/**
 * Class NewsRepository
 *
 * @package Nantarena\NewsBundle\Repository
 */
class NewsRepository extends EntityRepository
{
    public function findLatestPublished($limit = 5)
    {
        return $this->findBy(array('state' => News::STATE_PUBLISHED), array(
            'id' => 'desc',
        ), $limit);
    }

    public function findAllPublished($limit = null, $offset = null)
    {
        return $this->findBy(array('state' => News::STATE_PUBLISHED), array(
            'id' => 'desc',
        ), $limit, $offset);
    }

    public function findAllPublishedByCategory(Category $category, $limit = null, $offset = null)
    {
        return $this->findBy(array('category' => $category, 'state' => News::STATE_PUBLISHED), array(
            'id' => 'desc',
        ), $limit, $offset);
    }

    public function findAllOrderedByIdDesc()
    {
        return $this->findBy(array(), array(
            'id' => 'desc',
        ));
    }

    public function countAllPublished()
    {
        return $this
            ->createQueryBuilder('n')
            ->select('count(n.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
