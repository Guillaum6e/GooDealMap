<?php

namespace App\DataFixtures;

use App\Entity\Devs;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DevsFixtures extends Fixture
{
    private const DEVS = [
        [
            'firstname' => 'Franck',
            'lastname' => 'Depoorter',
            'linkedin' => 'https://www.linkedin.com/in/franck-depoorter/',
            'github' => 'https://github.com/Franck59840',
            'image' => 'franck.jpg',
        ],
        [
            'firstname' => 'Guillaume',
            'lastname' => 'Gros',
            'linkedin' => 'https://www.linkedin.com/in/11gg/',
            'github' => 'https://github.com/Guillaum6e',
            'image' => 'guillaume.jpeg',
        ],
        [
            'firstname' => 'Omar',
            'lastname' => 'Lahouaichri',
            'linkedin' => 'https://www.linkedin.com/in/omar-lahouaichri-072232254/',
            'github' => 'https://github.com/moioms',
            'image' => 'omar.jpg',
        ],
        [
            'firstname' => 'Julie',
            'lastname' => 'Jeançon-Donon',
            'linkedin' => 'https://www.linkedin.com/in/julie-jeançon-donon/',
            'github' => 'https://github.com/julie-jeancon-donon',
            'image' => 'julie.jpeg',
        ],
        [
            'firstname' => 'Thomas',
            'lastname' => 'Henriet',
            'linkedin' => 'https://www.linkedin.com/in/tom-henriet/',
            'github' => 'https://github.com/thenriet',
            'image' => 'thomas.jpeg',
        ]
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::DEVS as $devsinfos) {
            $devs = new Devs();
            $devs->setFirstname($devsinfos['firstname']);
            $devs->setLastname($devsinfos['lastname']);
            $devs->setLinkedin($devsinfos['linkedin']);
            $devs->setGithub($devsinfos['github']);
            $devs->setImage($devsinfos['image']);
            $manager->persist($devs);
        };

        $manager->flush();
    }
}
