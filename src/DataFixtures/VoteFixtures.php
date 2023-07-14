<?php

namespace App\DataFixtures;

use App\Entity\Vote;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class VoteFixtures extends Fixture implements DependentFixtureInterface
{
    public const VOTES = 50;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::VOTES; $i++) {
            $vote = new Vote();
            $vote->setVoting($faker->randomElement([-1, 1]));
            $vote->setDecision(
                $this->getReference('decision_' . $faker->numberBetween(0, DecisionFixtures::DECISION_NUMBER - 1))
            );
            $vote->setUser($this->getReference('user_' . $faker->numberBetween(4, UserFixtures::USER_NUMBER - 1)));
            $manager->persist($vote);
        }


        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            DecisionFixtures::class,
            UserFixtures::class,
        ];
    }
}
