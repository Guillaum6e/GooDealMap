<?php

namespace App\Controller;

use App\Form\FormGooDealType;
use App\Entity\Announcement;
use App\Repository\AnnouncementRepository;
use App\Repository\RegionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;

#[Route('/form', name: 'form_goodeal')]
class FormAddGooDealController extends AbstractController
{
    #[Route('/new', name: '_new')]
    public function new(Request $request, AnnouncementRepository $annRepository, RegionRepository $region): Response
    {
        $announcement = new Announcement();
        $announcement->setDate(new DateTime());
        $formGD = $this->createForm(FormGooDealType::class, $announcement);
        $formGD->handleRequest($request);
        if ($formGD->isSubmitted() && $formGD->isValid()) {
            $annRepository->save($announcement, true);
            $region = $announcement->getRegion();
            $id = $region->getId();

            return $this->redirectToRoute('announcements_region', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('form/formGoodeal.html.twig', [
            'announcement' => $announcement,
            'formGD' => $formGD,
        ]);
    }
}
