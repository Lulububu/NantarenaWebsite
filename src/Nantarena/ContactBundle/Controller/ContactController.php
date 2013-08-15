<?php

namespace Nantarena\ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
// Manage routing
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
// Request for form
use Symfony\Component\HttpFoundation\Request;

// Form
use Nantarena\ContactBundle\Form\Type\ContactType;
use Nantarena\ContactBundle\Form\Model\Contact;

/**
 * Class ContactController
 *
 * @package Nantarena\ContactBundle\Controller
 *
 * @Route("/contact")
 */
class ContactController extends Controller
{
    /**
     * @Route("/", name="nantarena_contact")
     * @Template()
     */
    public function contactAction(Request $request)
    {
        $contact = new Contact();

        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->get('security.context')->getToken()->getUser();
            $contact->setEmail($user->getEmail());
        }

        $form = $this->createForm(new ContactType(), $contact, array(
            'action' => $this->generateUrl('nantarena_contact'),
            'method' => 'POST',
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            // message construction
            // if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            //     $user = $this->get('security.context')->getToken()->getUser();
            //     $src_email = array($contact->getEmail() => $user->getPseudo());
            // } else {
            //     $src_email = $contact->getEmail();
            // }

            $src_email = $contact->getEmail();
            $dst_email = 'contact@nantarena.net';
            $objet = '[' . $contact->getCategory()->getTag() . '] ' . $contact->getObject();
            $content = $contact->getContent();


            // Create the message
            $message = \Swift_Message::newInstance()
                ->setSubject($objet)
                ->setFrom($src_email)
                ->setSender($src_email)
                ->setReturnPath($src_email)
                ->setTo($dst_email)
                ->setBody($content)
                ;

            $this->get('mailer')->send($message);

            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('contact.contact.form.flash_success'));

            // Cas d'erreur ???
            // $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('contact.contact.form.flash_error'));

            return $this->redirect($this->generateUrl('nantarena_contact'));
        }

        return array(
            'form' => $form->createView()
        );
    }
}
