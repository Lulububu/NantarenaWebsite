<?php

namespace Nantarena\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    /**
     * Récupère le contexte de sécurité
     *
     * @return \Symfony\Component\Security\Core\SecurityContext
     */
    public function getSecurityContext()
    {
        return $this->get('security.context');
    }

    /**
     * Ajoute un flash message en le traduisant
     *
     * @param string $type
     * @param string $key
     * @param array  $parameters
     * @param string $domain
     * @param string $locale
     */
    public function addFlash($type, $key, $parameters = array(), $domain = null, $locale = null)
    {
        $this->get('session')->getFlashBag()->add(
            $type, $this->trans($key, $parameters, $domain, $locale)
        );
    }

    /**
     * Raccourci pour utiliser le translator
     *
     * @param string $key
     * @param array  $parameters
     * @param string $domain
     * @param string $locale
     * @return string
     */
    public function trans($key, $parameters = array(), $domain = null, $locale = null)
    {
        return $this->get('translator')->trans($key, $parameters, $domain, $locale);
    }
}
