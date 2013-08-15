<?php

namespace Nantarena\ForumBundle\Manager;

use Nantarena\ForumBundle\Entity\Category;
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
        return $this->router->generate('nantarena_forum_category_index', array(
            'id' => $category->getId(),
            'slug' => $category->getSlug(),
        ));
    }
}
