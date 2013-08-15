<?php

namespace Nantarena\ForumBundle\Controller;

use Nantarena\ForumBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CategoryController extends Controller
{
    /**
     * @Route("/{id}-{slug}")
     * @Template()
     */
    public function indexAction(Category $category)
    {
        $this->get('nantarena_site.breadcrumb')
            ->push(
                $this->get('translator')->trans('forum.index.title'),
                $this->generateUrl('nantarena_forum_default_index')
            )
            ->push(
                $category->getName(),
                $this->get('nantarena_forum.category_manager')->getCategoryPath($category)
            );

        return array(
            'category' => $category,
        );
    }
}
