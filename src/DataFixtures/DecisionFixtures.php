<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Decision;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\StatusFixtures;
use App\DataFixtures\CategoryFixtures;
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

            $decision->setTitle($faker->realText(50));
            $decision->setStartDate($faker->dateTime());
            $decision->setDescription($faker->realText(200));
            $decision->setStatus($this->getReference('status_' . $faker->numberBetween(0, 5)));

            $decision->setCategory($this->getReference('category_' . $faker->numberBetween(0, 4)));
            $decision->setUser($this->getReference('user_' . $faker->numberBetween(0, UserFixtures::USER_NUMBER - 1)));

            $this->addReference('decision_' . $i, $decision);
            $manager->persist($decision);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            StatusFixtures::class,
            CategoryFixtures::class,
            UserFixtures::class,
        ];
    }
}
