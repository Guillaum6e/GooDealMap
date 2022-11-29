<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    private const CATEGORIES = [
        [
            'category' => "Evénements",
            'slug' => 'evenements',
        ],
        [
            'category' => "Hébergements",
            'slug' => 'hebergements',
        ],
        [
            'category' => "Restaurations",
            'slug' => 'restaurations',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::CATEGORIES as $categoryName) {
            $category = new Category();
            $category->setName($categoryName['category']);
            $manager->persist($category);
            $this->addReference('category_' . $categoryName['slug'], $category);
        };
        $manager->flush();
    }
}
