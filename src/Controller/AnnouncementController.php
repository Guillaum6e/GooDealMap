<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AnnouncementRepository;
use App\Repository\RegionRepository;
use App\Entity\Announcement;
use App\Entity\Region;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;

#[Route('/announcements', name: 'announcements_')]
class AnnouncementController extends AbstractController
{
    public const EVENTS = [
        0 => 'tous',
        1 => 'evenements',
        2 => 'restaurations',
        3 => 'hebergements'
    ];

    #[Route('/region/{id}', methods: ['GET'], requirements: ['region' => '\d+'], name: 'region')]
    public function showAnnouncementsByRegion(
        Request $request,
        //Remove param converter for region
        // Region $region,
        RegionRepository $regionRepo,
        int $id,
        AnnouncementRepository $annRepository,
        CategoryRepository $catRepository,
    ): Response {
        $region = null;
        if ($id > 0) {
            $region = $regionRepo->findOneById($id);
            $announcements = $annRepository->findBy(["region" => $region->getId()]);
        } else {
            $announcements = $annRepository->findAll();
        }
        $category = "tous";
        $regions = $regionRepo->findAll();
        if ($request->query->get("announcement") && $request->query->get("announcement") !== "tous") {
            $category = $request->query->get("announcement");
            $categoryObject = $catRepository->findOneBy(["name" => $category]);
            if ($id > 0) {
                $announcements = $annRepository->findBy(
                    ['region' => $region->getId(), "category" => $categoryObject->getId()]
                );
            } else {
                $announcements = $annRepository->findBy(["category" => $categoryObject->getId()]);
            }
        } else {
            if ($id > 0) {
                $announcements = $annRepository->findBy(['region' => $region->getId()]);
            }
        }

        //dd($announcements);
        $events = self::EVENTS;
        return $this->render(
            'announcement/index.html.twig',
            [
                'region' => $region,
                'regions' => $regions,
                'announcements' => $announcements,
                'events' => $events,
                'selectedRegion' => $id,
                'category' => $category
            ]
        );
    }

    // #[Route(
    //     '/region/{id}/event/{event}',
    //     methods: ['GET'],
    //     name: 'region/event',
    // )]
    // public function showAnnouncementsByEvents(Region $region, RegionRepository $regionRepo, int $id): Response
    // {

    //     $regionById = $regionRepo->findById($id);
    //     $announcements = $regionById->getAnnouncements();
    //     $events = self::EVENTS;
    //     return $this->render(
    //         'announcement/index.html.twig',
    //         [
    //             'region' => $region,
    //             'regions' => $regionById,
    //             'announcements' => $announcements,
    //             'selectedRegion' => $id,
    //             'events' => $events,
    //         ]
    //     );
    // }

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
        $region = $announcement->getRegion();
        $id = $region->getId();
        return $this->redirectToRoute('announcements_region', ['id' => $id], Response::HTTP_SEE_OTHER);
    }
}
