<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AnnouncementRepository;
use App\Repository\RegionRepository;
use App\Entity\Announcement;
use App\Entity\Region;

/* 'announcements' => ['AnnouncementController', 'index',],
'announcements/card' => ['AnnouncementController', 'show', ['id']],
'announcements/delete' => ['AnnouncementController', 'delete', ['id']], */


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

    /**
     * List announcements
     */
    #[Route('/', methods: ['GET'], name: 'index')]
    public function index(AnnouncementRepository $announcementRepo, RegionRepository $regionRepo): Response
    {
        // $announcementManager = new AnnouncementManager();
        // $active = 'tous';
        // $regionManager = new RegionManager();
        $where = [];
        $selected = '';
        $page = 1;
        $error = '';

        $announcements = $announcementRepo->findAll();
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
                    // $active = $where['category'];
                } else {
                    $error .= 'Categorie n\'existe pas'; //throw new \Exception('Categorie n\'existe pas');
                    $where = [];
                }
            }
        }

        // $regions = $regionManager->select();
        $regions = $regionRepo->findAll();
        //$region = $regionRepo->findById();
        // $announcements = $announcementManager->select($where);
        // $announcementsByRegion = $announcements->getRegion();


        $numrows = count($announcements);
        $numpages = ceil($numrows / $this->perPage);

        if ($numpages > 1) {
            $page = (!isset($_GET['page']) || $_GET['page'] == 0 || $_GET['page'] > $numpages) ? 1 : $_GET['page'];
            $begin = ($page - 1) * $this->perPage;
            $end = $this->perPage;
            $where['limitQuery'] = ' LIMIT ' . $begin . ',' . $end;
            //$where['pageURL'] = '&page=' . $where['page'];
            // $announcements = $announcementManager->select($where);
            unset($where['limitQuery']);
        }
        return $this->render('announcement/index.html.twig', [
            'announcements' => $announcements,
            'events' => self::EVENTS,
            /*'active' => $active,*/
            'regions' => $regions,
            //'region' => $region,
            'selected' => $selected,
            'numpages' => $numpages,
            'where' => $where,
            'page' => $page,
            'error' => $error
        ]);
    }

    //Form add annonce
    public function showFormAddGoodeal(): string
    {
        return $this->render('announcement/addGoodeal.html.twig');
    }

    /**
     * Show one announcement
     */

    #[Route('/card/{id}', methods: ['GET'], requirements: ['id' => '\d+'], name: 'show')]
    public function show(AnnouncementRepository $announcementRepo, int $id = 1): Response
    {
        $announcement = $announcementRepo->findOneBy(['id' => $id]);
        // $announcement = $announcementManager->selectById($id);
        /* if (isset($_SERVER['HTTP_REFERER'])) {
            $announcement['ref'] = $_SERVER['HTTP_REFERER'];
        } */
        return $this->render('announcement/detail.html.twig', ['announcement' => $announcement]);
    }


    /**
     * List announcements with given region
     */

    #[Route('/region/{region}', methods: ['GET'], requirements: ['region' => '\d+'], name: 'region')]
    public function showAnnouncementsByRegion(Region $region): Response
    {
        $announcements = $region->getAnnouncements();
        $events = self::EVENTS;
        return $this->render(
            'announcement/index.html.twig',
            [
                'region' => $region,
                'announcements' => $announcements,
                'events' => $events

            ]
        );
    }

    /**
     * Delete announcement with given id
     */

    #[Route('/delete', methods: ['POST'], requirements: ['id' => '\d+'], name: 'delete')]
    public function delete(AnnouncementRepository $announcementRepo, int $id = 1): void
    {
        //$announcementManager = new AnnouncementManager();
        //$announcementManager->deleteById($id);

        $announcement = $announcementRepo->findOneBy(['id' => $id]);
        $announcementRepo->remove($announcement);

        // header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}
