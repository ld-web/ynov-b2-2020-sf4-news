<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
  /**
   * @Route("/contact", name="contact")
   */
  public function index(Request $request, EntityManagerInterface $em): Response
  {
    $contact = new Contact();
    $form = $this->createForm(ContactType::class, $contact);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      try {
        $em->persist($contact);
        $em->flush();
        
        $this->addFlash(
          'success',
          'Votre demande a bien été enregistrée !'
        );
      } catch (Exception $e) {
        $this->addFlash(
          'danger',
          'Une erreur est survenue pendant l\'enregistrement de votre demande'
        );
      }
    }

    return $this->render('contact/index.html.twig', [
      'contact_form' => $form->createView()
    ]);
  }
}
