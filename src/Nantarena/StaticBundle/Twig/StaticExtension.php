<?php

namespace Nantarena\StaticBundle\Twig;

use Nantarena\StaticBundle\Entity\StaticContent;
use Nantarena\StaticBundle\Manager\StaticContentManager;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;

/**
 * Class StaticExtension
 *
 * Fonctions Twig utilitaires pour le bundle de contenu statique
 *
 * @package Nantarena\StaticBundle\Twig
 */
class StaticExtension extends \Twig_Extension
{
    /**
     * @var StaticContentManager
     */
    private $staticContentManager;

    /**
     * @var Translator
     */
    private $translator;

    /**
     * @param StaticContentManager $staticContentManager
     * @param Translator $translator
     */
    public function __construct(StaticContentManager $staticContentManager, Translator $translator)
    {
        $this->staticContentManager = $staticContentManager;
        $this->translator = $translator;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('static_link', array($this, 'getStaticLink')),
            new \Twig_SimpleFunction('static_state', array($this, 'getStaticState')),
            new \Twig_SimpleFunction('static_path', array($this, 'getStaticPath')),
            new \Twig_SimpleFunction('static_edit_path', array($this, 'getEditPath')),
            new \Twig_SimpleFunction('static_delete_path', array($this, 'getDeletePath')),
        );
    }

    public function getStaticLink($page)
    {
        return $this->staticContentManager->getStaticContentLink($page);
    }

    public function getStaticPath(StaticContent $content)
    {
        return $this->staticContentManager->getStaticContentPath($content);
    }

    public function getStaticState(StaticContent $content)
    {
        if ($content->getState() === StaticContent::STATE_PUBLISHED) {
            return $this->translator->trans('static.state.published');
        } else {
            return $this->translator->trans('static.state.unpublished');
        }
    }

    public function getEditPath(StaticContent $content)
    {
        return $this->staticContentManager->getEditPath($content);
    }

    public function getDeletePath(StaticContent $content)
    {
        return $this->staticContentManager->getDeletePath($content);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'static_extension';
    }
}