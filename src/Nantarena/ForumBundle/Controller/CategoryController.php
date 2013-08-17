<?php

namespace Nantarena\ForumBundle\Controller;

use Nantarena\ForumBundle\Entity\Category;
use Nantarena\SiteBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route("/forum")
 */
class CategoryController extends BaseController
{
    /**
     * @Route("/{id}-{slug}")
     * @ParamConverter("category", class="NantarenaForumBundle:Category", options={"repository_method" = "findWithJoins"})
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
