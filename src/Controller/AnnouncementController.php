<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AnnouncementRepository;
use App\Repository\RegionRepository;
use App\Entity\Announcement;
use App\Entity\Region;

#[Route('/announcements', name: 'announcements_')]
class AnnouncementController extends AbstractController
{
    public const EVENTS = [
        0 => 'tous',
        1 => 'evenements',
        2 => 'restaurations',
        3 => 'hebergements'
    ];

    #[Route('/region/{region}', methods: ['GET'], requirements: ['region' => '\d+'], name: 'region')]
    public function showAnnouncementsByRegion(Region $region, RegionRepository $regionRepo): Response
    {

        $announcements = $region->getAnnouncements();
        $regions = $regionRepo->findAll();

        $events = self::EVENTS;
        return $this->render(
            'announcement/index.html.twig',
            [
                'region' => $region,
                'regions' => $regions,
                'announcements' => $announcements,
                'events' => $events,
            ]
        );
    }

    #[Route('/region/{region}/event/{event}', name: 'region/event')]
    public function showAnnouncementsByEvents(Region $region, RegionRepository $regionRepo): Response
    {
        $announcements = $region->getAnnouncements();
        $regions = $regionRepo->findAll();

        return $this->render(
            'announcement/index.html.twig',
            [
                'region' => $region,
                'regions' => $regions,
                'announcements' => $announcements,
            ]
        );
    }

    /**
     * Show one specific announcement
     */

    #[Route('/card/{id}', methods: ['GET'], requirements: ['id' => '\d+'], name: 'show')]
    public function show(AnnouncementRepository $announcementRepo, int $id = 1): Response
    {
        $announcement = $announcementRepo->findOneBy(['id' => $id]);
        $user = $announcement->getUser();

        return $this->render('announcement/detail.html.twig', [
            'announcement' => $announcement,
            'user' => $user
        ]);
    }

    /**
     * Delete announcement with given id
     */

    #[Route('/delete/{id}', requirements: ['id' => '\d+'], name: 'delete')]
    public function delete(Announcement $announcement, AnnouncementRepository $announcementRepo): Response
    {

        $announcementRepo->remove($announcement, true);
        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }
}
