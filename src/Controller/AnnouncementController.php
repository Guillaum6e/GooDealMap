<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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

    private int $perPage = 3;

    #[Route('/region/{region}', methods: ['GET'], requirements: ['region' => '\d+'], name: 'region')]
    public function showAnnouncementsByRegion(Region $region, RegionRepository $regionRepo): Response
    {
        $where = [];
        $selected = '';
        $page = 1;
        $error = '';
        $active = 'tous';

        $announcements = $region->getAnnouncements();
        $regions = $regionRepo->findAll();

        if (isset($_GET['search'])) {
            $where['search'] = htmlentities($_GET['search']);
        } else {
            if (isset($_GET['region_id'])) {
                $where['region_id'] = (int) $_GET['region_id'];
                $selected = $where['region_id'];
            }
            if (isset($_GET['category'])) {
                if (in_array($_GET['category'], self::EVENTS)) {
                    $where['category'] = $_GET['category'];
                    $active = $where['category'];
                } else {
                    $error .= 'Categorie n\'existe pas'; //throw new \Exception('Categorie n\'existe pas');
                    $where = [];
                }
            }
        }

        $numrows = count($announcements);
        $numpages = ceil($numrows / $this->perPage);

        if ($numpages > 1) {
            $page = (!isset($_GET['page']) || $_GET['page'] == 0 || $_GET['page'] > $numpages) ? 1 : $_GET['page'];
            $begin = ($page - 1) * $this->perPage;
            $end = $this->perPage;
            $where['limitQuery'] = ' LIMIT ' . $begin . ',' . $end;
            // $where['pageURL'] = '&page=' . $where['page'];
            unset($where['limitQuery']);
        }

        $events = self::EVENTS;
        return $this->render(
            'announcement/index.html.twig',
            [
                'region' => $region,
                'regions' => $regions,
                'announcements' => $announcements,
                'events' => $events,
                'active' => $active,
                'selected' => $selected,
                'numpages' => $numpages,
                'where' => $where,
                'page' => $page,
                'error' => $error
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

    public function showFormAddGoodeal(): string
    {
        return $this->render('announcement/addGoodeal.html.twig');
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
    public function delete(Request $request, Announcement $announcement, AnnouncementRepository $announcementRepo): Response
    {
        /* if ($this->isCsrfTokenValid('delete' . $announcement->getId(), $request->request->get('_token'))) {
        } */

        $announcementRepo->remove($announcement, true);
        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }
}
