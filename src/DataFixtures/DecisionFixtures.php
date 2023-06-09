<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Decision;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class DecisionFixtures extends Fixture
{
    public const DECISION_NUMBER = 12;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::DECISION_NUMBER; $i++) {
            $decision = new Decision();
            $decision->setTitle($faker->sentence());
            $decision->setStartDate($faker->dateTime());
            $decision->setDescription($faker->paragraph());

            $manager->persist($decision);
        }

        $manager->flush();
    }
}
