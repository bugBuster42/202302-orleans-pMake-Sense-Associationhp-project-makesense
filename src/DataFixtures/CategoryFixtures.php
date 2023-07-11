<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\HttpFoundation\File\File;

class CategoryFixtures extends Fixture
{
    public const CATEGORIES = [
        ['name' => 'Environnement', 'image' => 'environnement.jpg'],
        ['name' => 'Économie', 'image' => 'economie.jpg'],
        ['name' => 'Droit', 'image' => 'droit1.jpg'],
        ['name' => 'Professionnel', 'image' => 'professionnel.jpg'],
        ['name' => 'Personnel', 'image' => 'personnel.jpg'],
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
                'public/uploads/images/category/' . $categoryData['image']
            );
            $manager->persist($category);
        }

        $manager->flush();
    }
}
