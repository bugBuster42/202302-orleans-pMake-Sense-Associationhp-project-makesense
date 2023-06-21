<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Decision;
use App\DataFixtures\StatusFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class DecisionFixtures extends Fixture implements DependentFixtureInterface
{
    public const DECISION_NUMBER = 24;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < self::DECISION_NUMBER; $i++) {
            $decision = new Decision();
            $decision->setTitle($faker->sentence());
            $decision->setStartDate($faker->dateTime());
            $decision->setDescription($faker->paragraph());

            $decision->setStatus($this->getReference('status_' . $faker->numberBetween(0, 5)));
            $this->addReference('decision_' . $i, $decision);
            $manager->persist($decision);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            StatusFixtures::class,
        ];
    }
}
