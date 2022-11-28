<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ContactType;
use App\Entity\Contact;
use App\Repository\ContactRepository;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'index')]
    public function new(Request $request, ContactRepository $contactRepository): Response
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $contactRepository->save($contact, true);

            return $this->redirectToRoute('app_home');
        }

        return $this->renderForm('contact/index.html.twig', [
            'form' => $form,
        ]);
    }
}
