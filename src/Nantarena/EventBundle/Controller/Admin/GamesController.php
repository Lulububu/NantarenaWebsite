<?php

namespace Nantarena\EventBundle\Controller\Admin;

use Nantarena\EventBundle\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Nantarena\EventBundle\Form\Type\GameType;

/**
 * Class GamesController
 *
 * @package Nantarena\EventBundle\Controller\Admin
 *
 * @Route("/admin/event/games")
 */
class GamesController extends Controller
{
    /**
     * @Route("/", name="nantarena_event_admin_games")
     * @Template()
     */
    public function listAction()
    {
        return array(
            'games' => $this->getDoctrine()->getRepository('NantarenaEventBundle:Game')->findAll(),
        );
    }

    /**
     * @Route("/create", name="nantarena_event_admin_games_create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $game = new Game();

        $form = $this->createForm(new GameType(), $game, array(
            'action' => $this->generateUrl('nantarena_event_admin_games_create'),
            'method' => 'POST',
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $translator = $this->get('translator');
            $flashbag = $this->get('session')->getFlashBag();

            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($game);
                $em->flush();

                $flashbag->add('success', $translator->trans('event.admin.games.create.flash_success'));
                return $this->redirect($this->generateUrl('nantarena_event_admin_games'));

            } catch (\Exception $e) {
                $flashbag->add('error', $translator->trans('event.admin.games.create.flash_error'));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/edit/{id}", name="nantarena_event_admin_games_edit")
     * @Template()
     */
    public function editAction(Request $request, Game $game)
    {
        $form = $this->createForm(new GameType(), $game, array(
            'action' => $this->generateUrl('nantarena_event_admin_games_edit', array(
                'id' => $game->getId()
            )),
            'method' => 'POST',
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $translator = $this->get('translator');
            $flashbag = $this->get('session')->getFlashBag();

            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($game);
                $em->flush();

                $flashbag->add('success', $translator->trans('event.admin.games.edit.flash_success'));
                return $this->redirect($this->generateUrl('nantarena_event_admin_games'));

            } catch (\Exception $e) {
                $flashbag->add('error', $translator->trans('event.admin.games.edit.flash_error'));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/delete/{id}", name="nantarena_event_admin_games_delete")
     * @Template()
     */
    public function deleteAction(Request $request, Game $game)
    {
        $form = $this->createDeleteForm($game->getId());
        $form->handleRequest($request);

        if ($form->isValid()) {
            $translator = $this->get('translator');
            $flashbag = $this->get('session')->getFlashBag();

            try {
                if ($form->get('id')->getData() == $game->getId()) {
                    $em = $this->getDoctrine()->getManager();
                    $em->remove($game);
                    $em->flush();

                    $flashbag->add('success', $translator->trans('event.admin.games.delete.flash_success'));
                } else {
                    throw new \Exception;
                }
            } catch (\Exception $e) {
                $flashbag->add('error', $translator->trans('event.admin.games.delete.flash_error'));
            }

            return $this->redirect($this->generateUrl('nantarena_event_admin_games'));
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to delete a Game entity by id.
     *
     * @param integer $id
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->add('submit', 'submit')
            ->setMethod('POST')
            ->setAction($this->generateUrl('nantarena_event_admin_games_delete', array(
                'id' => $id
            )))
            ->getForm();
    }
}
