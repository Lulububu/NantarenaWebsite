<?php

namespace Nantarena\ForumBundle\Controller;

use Nantarena\ForumBundle\Entity\Category;
use Nantarena\SiteBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CategoryController extends BaseController
{
    /**
     * @Route("/{id}-{slug}")
     * @Template()
     */
    public function indexAction(Category $category)
    {
        if (!$this->getSecurityContext()->isGranted('VIEW', $category)) {
            throw new AccessDeniedException();
        }

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
