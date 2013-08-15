<?php

namespace Nantarena\SiteBundle\Twig;

use Nantarena\SiteBundle\Navigation\Breadcrumb;

class BreadcrumbExtension extends \Twig_Extension
{
    /**
     * @var Breadcrumb
     */
    private $breadcrumb;

    /**
     * Constructeur
     */
    public function __construct(Breadcrumb $breadcrumb)
    {
        $this->breadcrumb = $breadcrumb;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('render_breadcrumb', array($this, 'render'), array(
                'needs_environment' => true,
                'is_safe' => array('html'),
            )),
            new \Twig_SimpleFunction('get_breadcrumb', array($this, 'getQueue')),
        );
    }

    /**
     * @return \SplQueue
     */
    public function getQueue()
    {
        return $this->breadcrumb->getQueue();
    }

    /**
     * @param \Twig_Environment $env
     * @return string
     */
    public function render(\Twig_Environment $env)
    {
        return $env->render('NantarenaSiteBundle:Breadcrumb:breadcrumb.html.twig', array(
            'breadcrumb' => $this->breadcrumb->getQueue(),
        ));
    }

    public function getName()
    {
        return 'breadcrumb_extension';
    }
}
