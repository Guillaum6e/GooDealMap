<?php

namespace App\DataFixtures;

use App\Entity\Region;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RegionFixtures extends Fixture
{
    private const REGIONS = [
        [
            'region' => 'Grand Est',
            'slug' => 'grand-est',
        ],
        [
            'region' => 'Nouvelle-Aquitaine',
            'slug' => 'nouvelle-aquitaine',
        ],
        [
            'region' => 'Auvergne-Rhône-Alpes',
            'slug' => 'auvergne-rhone-alpes',
        ],
        [
            'region' => 'Bourgogne-Franche-Comté',
            'slug' => 'bougogne-franche-comte',
        ],
        [
            'region' => 'Bretagne',
            'slug' => 'bretagne',
        ],
        [
            'region' => 'Centre-Val de Loire',
            'slug' => 'centre-val-de-loire',
        ],
        [
            'region' => 'Corse',
            'slug' => 'corse',
        ],
        [
            'region' => 'Île de France',
            'slug' => 'ile-de-france',
        ],
        [
            'region' => 'Occitanie',
            'slug' => 'occitanie',
        ],
        [
            'region' => 'Hauts de France',
            'slug' => 'hdf',
        ],
        [
            'region' => 'Normandie',
            'slug' => 'normandie',
        ],
        [
            'region' => 'Pays de la Loire',
            'slug' => 'pays-de-la-loire',
        ],
        [
            'region' => 'Provence-Alpes-Côte d\'Azur',
            'slug' => 'paca',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::REGIONS as $regionName) {
            $region = new Region();
            $region->setRegionName($regionName['region']);
            $manager->persist($region);
            $this->addReference('region_' . $regionName['slug'], $region);
        };
        $manager->flush();
    }
}
