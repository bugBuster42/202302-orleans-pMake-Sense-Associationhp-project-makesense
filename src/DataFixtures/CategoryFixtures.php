<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\HttpFoundation\File\File;

class CategoryFixtures extends Fixture
{
    public const CATEGORIES = [
        ['name' => 'Environnement', 'image' => 'environnement.webp'],
        ['name' => 'Économie', 'image' => 'economie.webp'],
        ['name' => 'Droit', 'image' => 'droit.webp'],
        ['name' => 'Professionnel', 'image' => 'professionnel.webp'],
        ['name' => 'Personnel', 'image' => 'personnel.webp'],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::CATEGORIES as $key => $categoryData) {
            $category = new Category();
            $category->setTitle($categoryData['name']);
            $category->setImage($categoryData['image']);

            $this->addReference('category_' . $key, $category);
            copy(
                __DIR__ . '/images/' . $categoryData['image'],
                'src/DataFixtures/images/' . $categoryData['image']
            );
            $manager->persist($category);
        }

        $manager->flush();
    }
}
