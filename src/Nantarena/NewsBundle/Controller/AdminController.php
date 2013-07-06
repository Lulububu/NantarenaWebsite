<?php

namespace Nantarena\NewsBundle\Controller;

use Nantarena\NewsBundle\Entity\News;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class AdminController
 *
 * @package Nantarena\NewsBundle\Controller
 *
 * @Route("/admin/news")
 */
class AdminController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return array(
            'news' => $this->getDoctrine()->getRepository('NantarenaNewsBundle:News')->findAll(),
        );
    }

    /**
     * @Route("/edit/{id}")
     * @Template()
     */
    public function editAction($id, News $news)
    {
    }

    /**
     * @Route("/delete/{id}")
     * @Template()
     */
    public function deleteAction($id, News $news)
    {
    }

    /**
     * @Route("/new")
     * @Template()
     */
    public function newAction()
    {
    }

    /**
     * Creates a form to delete a News entity by id.
     *
     * @param integer $id
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm();
    }
}
