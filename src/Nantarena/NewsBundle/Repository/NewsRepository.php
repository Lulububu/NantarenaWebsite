<?php

namespace Nantarena\NewsBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Nantarena\NewsBundle\Entity\Category;
use Nantarena\NewsBundle\Entity\News;

/**
 * Class NewsRepository
 *
 * @package Nantarena\NewsBundle\Repository
 */
class NewsRepository extends EntityRepository
{
    public function getQueryBuilder()
    {
        return $this->createQueryBuilder('n');
    }

    public function addAuthor(QueryBuilder $qb)
    {
        $qb->join('n.author', 'a')->addSelect('a');

        return $this;
    }

    public function addComments(QueryBuilder $qb)
    {
        $qb->leftJoin('n.comments', 'c')->addSelect('c');

        return $this;
    }

    public function addComment(QueryBuilder $qb)
    {
        $qb->leftJoin('n.comments', 'c')->addSelect('c');

        return $this;
    }

    /**
     * @param QueryBuilder $qb
     * @return $this
     */
    public function addCategory(QueryBuilder $qb)
    {
        $qb->join('n.category', 't')->addSelect('t');

        return $this;
    }

    public function filterState(QueryBuilder $qb, $state)
    {
        $qb
            ->andWhere('n.state = :state')
            ->setParameter('state', $state);

        return $this;
    }

    public function filterCategory(QueryBuilder $qb, Category $category)
    {
        $qb
            ->andWhere('n.category = :category')
            ->setParameter('category', $category);

        return $this;
    }

    public function findLatestPublished($limit = 5)
    {
        $qb = $this->getQueryBuilder();

        $this->addAuthor($qb);
        $this->addCategory($qb);
        $this->addComment($qb);
        $this->filterState($qb, News::STATE_PUBLISHED);

        $qb
            ->addOrderBy('n.id', 'desc')
            ->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }

    public function findAllPublished($limit = null, $offset = null)
    {
        $qb = $this->getQueryBuilder();

        $this->addAuthor($qb);
        $this->addCategory($qb);
        $this->addComment($qb);
        $this->filterState($qb, News::STATE_PUBLISHED);

        $qb
            ->addOrderBy('n.id', 'desc')
            ->setMaxResults($limit)
            ->setFirstResult($offset);

        return $qb->getQuery()->getResult();
    }

    public function findAllPublishedByCategory(Category $category, $limit = null, $offset = null)
    {
        $qb = $this->getQueryBuilder();

        $this->addAuthor($qb);
        $this->addCategory($qb);
        $this->addComment($qb);
        $this->filterState($qb, News::STATE_PUBLISHED);
        $this->filterCategory($qb, $category);

        $qb
            ->addOrderBy('n.id', 'desc')
            ->setMaxResults($limit)
            ->setFirstResult($offset);

        return $qb->getQuery()->getResult();
    }

    public function findAllOrderedByIdDesc()
    {
        return $this->findBy(array(), array(
            'id' => 'desc',
        ));
    }
}
