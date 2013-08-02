<?php

namespace Nantarena\SiteBundle\Twig;

use Nantarena\SiteBundle\Entity\Image;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ImageExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('imageLink', array($this, 'getImageLink')),
        );
    }

    public function getImageLink(Image $image)
    {
        return $image->getUrl();
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'image_extension';
    }
}
