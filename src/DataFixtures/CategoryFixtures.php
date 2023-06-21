<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoryFixtures extends Fixture
{
    public const CATEGORY = [
        'Environnement',
        'Économie',
        'Droit',
        'Professionnel',
        'Personnel',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::CATEGORY as $key => $categoryTitle) {
            $category = new Category();
            $category->setTitle($categoryTitle);
            $this->addReference('category_' . $key, $category);

            $manager->persist($category);
        }

        $manager->flush();
    }
}
