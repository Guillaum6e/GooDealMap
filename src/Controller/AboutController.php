<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\DevsRepository;

class AboutController extends AbstractController
{
    #[Route('/about', name: 'about_index')]
    public function index(DevsRepository $devsRepository): Response
    {
        return $this->render('about/about.html.twig', [
            'abouts' => $devsRepository->findAll(),]);
    }
}
