<?php

namespace Nantarena\SiteBundle\Twig;

/**
 * Class FormExtension
 *
 * Several utilities
 *
 * @package Nantarena\SiteBundle\Twig
 */
class FormExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            'colon' => new \Twig_Filter_Method($this, 'colon'),
        );
    }

    /**
     * Get translated label with additionnal colon
     *
     * @param $label
     * @return string
     */
    public function colon($label)
    {
        return $label.' :';
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'form_extension';
    }
}