<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Notification;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class NotificationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 3; $i++) {
            $notif = new Notification();
            $notif->setMessage('nouvelle décision : ' . $i);
            $notif->setUser($this->getReference('user_' . $faker->numberBetween(0, 2)));
            $notif->setDecision($this->getReference(
                'decision_' . $faker->numberBetween(0, DecisionFixtures::DECISION_NUMBER - 1)
            ));
            $notif->setIsRead(false);
            $manager->persist($notif);
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
