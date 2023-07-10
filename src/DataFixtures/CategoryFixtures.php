<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\HttpFoundation\File\File;

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

        $category = new Category();
        $category->setTitle('Environement');
        $category->setImage('fixtures/environnement.jpg');

        $this->addReference('category_0', $category);

        $manager->persist($category);



        $category = new Category();
        $category->setTitle('Économie');
        $category->setImage('fixtures/economie.jpg');

        $this->addReference('category_1', $category);

        $manager->persist($category);


        $category = new Category();
        $category->setTitle('Droit');
        $category->setImage('fixtures/droit1.jpg');
        $this->addReference('category_2', $category);

        $manager->persist($category);


        $category = new Category();
        $category->setTitle('Professionnel');
        $category->setImage('fixtures/professionnel.jpg');
        $this->addReference('category_3', $category);

        $manager->persist($category);

        $category = new Category();
        $category->setTitle('Personnel');
        $category->setImage('fixtures/personnel.jpg');
        $this->addReference('category_4', $category);

        $manager->persist($category);


        // foreach (self::CATEGORY as $key => $categoryTitle) {
        //     $category = new Category();
        //     $category->setTitle($categoryTitle);
        //     $this->addReference('category_' . $key, $category);
        //     $manager->persist($category);
        // }

        $manager->flush();
    }
}
