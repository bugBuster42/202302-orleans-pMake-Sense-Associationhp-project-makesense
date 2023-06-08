<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Decision;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class DecisionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i <= 12; $i++) {
            $decision = new Decision();
            $decision->setTitle($faker->sentence());
            $decision->setStartDate($faker->dateTime());
            $decision->setDescription($faker->paragraph());

            $manager->persist($decision);
        }

        $manager->flush();
    }
}
