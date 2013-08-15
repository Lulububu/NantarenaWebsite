<?php

namespace Nantarena\ContactBundle\Manager;

use Nantarena\ContactBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * Class CategoryManager
 *
 * @package Nantarena\ContactBundle\Manager
 */
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

    public function Category()
    {
        return $this->router->generate('nantarena_admin_contact_category_list');
    }

    public function getEditPath(Category $content)
    {
        return $this->router->generate('nantarena_admin_contact_category_edit', array(
            'id' => $content->getId(),
        ));
    }

    public function getDeletePath(Category $content)
    {
        return $this->router->generate('nantarena_admin_contact_category_delete', array(
            'id' => $content->getId(),
        ));
    }

    public function getCreatePath()
    {
        return $this->router->generate('nantarena_admin_contact_category_create');
    }
}