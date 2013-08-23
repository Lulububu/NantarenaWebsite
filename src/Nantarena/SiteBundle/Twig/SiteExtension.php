<?php

namespace Nantarena\SiteBundle\Twig;
use Nantarena\UserBundle\Entity\User;

/**
 * Class SiteExtension
 *
 * @package Nantarena\SiteBundle\Twig
 */
class SiteExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('gravatar', array($this, 'getGravatar')),
        );
    }

    /**
     * Retourne le lien vers le gravatar
     *
     * @param User $user
     * @param $size
     * @return string
     */
    public function getGravatar(User $user, $size = 100, $default = '')
    {
        return 'http://www.gravatar.com/avatar/' . md5($user->getEmail()) . '?s=' . $size . '&d=' . urlencode($default);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'site_extension';
    }
}