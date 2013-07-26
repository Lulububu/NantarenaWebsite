<?php

namespace Nantarena\NewsBundle\Manager;

use Nantarena\NewsBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class CategoryManager
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Routing\Router
     */
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function getCategoryPath(Category $category)
    {
        return $this->router->generate('nantarena_news_category_index', array(
            'slug' => $category->getSlug(),
        ));
    }

    public function getEditPath(Category $category)
    {
        return $this->router->generate('nantarena_news_admin_categories_edit', array(
            'id' => $category->getId(),
        ));
    }

    public function getDeletePath(Category $category)
    {
        return $this->router->generate('nantarena_news_admin_categories_delete', array(
            'id' => $category->getId(),
        ));
    }

    public function getCreatePath()
    {
        return $this->router->generate('nantarena_news_admin_categories_create');
    }
}