<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AnnouncementRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(AnnouncementRepository $dealsRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'announcements' => $dealsRepository->findBy([], limit:4),]);
    }
}
