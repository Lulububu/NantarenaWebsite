<?php

namespace Nantarena\BannerBundle\Manager;

use Nantarena\BannerBundle\Entity\SponsorSlide;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * Class SponsorSlideManager
 *
 * @package Nantarena\BannerBundle\Manager
 */
class SponsorSlideManager
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Routing\Router
     */
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function SponsorSlide(SponsorSlide $content)
    {
        return $this->router->generate('nantarena_banner_sponsorslide_index', array(
            'slug' => $content->getSlug(),
        ));
    }

    public function getEditPath(SponsorSlide $content)
    {
        return $this->router->generate('nantarena_banner_sponsorslide_edit', array(
            'id' => $content->getId(),
        ));
    }

    public function getDeletePath(SponsorSlide $content)
    {
        return $this->router->generate('nantarena_banner_sponsorslide_delete', array(
            'id' => $content->getId(),
        ));
    }

    public function getCreatePath()
    {
        return $this->router->generate('nantarena_banner_sponsorslide_create');
    }
}