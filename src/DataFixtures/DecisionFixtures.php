<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Decision;
use App\DataFixtures\UserFixtures;
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

            $numberOfImpactedUsers = mt_rand(1, 5);
            $numberOfExpertUsers = mt_rand(1, 5);

            for ($j = 0; $j < $numberOfImpactedUsers; $j++) {
                $impactedUsers[] = $this->getReference('user_' . $faker->numberBetween(0, 39));
            }

            for ($j = 0; $j < $numberOfExpertUsers; $j++) {
                $expertUsers[] = $this->getReference('user_' . $faker->numberBetween(0, 40));
            }

            foreach ($impactedUsers as $impactedUser) {
                $decision->addImpactedUser($impactedUser);
            }
            foreach ($expertUsers as $expertUser) {
                $decision->addExpertUser($expertUser);
            }

            $decision->setTitle($faker->realText(50));
            $decision->setStartDate($faker->dateTimeBetween('-3 years', 'now'));
            $decision->setDescription($faker->paragraph(200));
            $decision->setCurrentPlace(array_rand(Decision::STATUS));
            $decision->setCategory($this->getReference('category_' . $faker->numberBetween(0, 4)));
            $decision->setUser($this->getReference('user_' . $faker->numberBetween(0, 40)));


            $this->addReference('decision_' . $i, $decision);
            $manager->persist($decision);
        }



        $decision = new Decision();
        $decision->setTitle('new test');
        $decision->setStartDate($faker->dateTimeBetween('-3 years', 'now'));
        $decision->setDescription($faker->paragraph(200));
        $decision->setCurrentPlace('opened');
        $decision->setCategory($this->getReference('category_' . $faker->numberBetween(0, 4)));
        $decision->setUser($this->getReference('user_0'));
        $this->addReference('decision_test', $decision);
        $manager->persist($decision);


        $decision = new Decision();
        $decision->setTitle('new test 2');
        $decision->setStartDate($faker->dateTimeBetween('-3 years', 'now'));
        $decision->setDescription($faker->paragraph(200));
        $decision->setCurrentPlace('opened');
        $decision->setCategory($this->getReference('category_' . $faker->numberBetween(0, 4)));
        $decision->setUser($this->getReference('user_0'));
        $this->addReference('decision_test_2', $decision);
        $manager->persist($decision);

        $decision = new Decision();
        $decision->setTitle('new test 3');
        $decision->setStartDate($faker->dateTimeBetween('-3 years', 'now'));
        $decision->setDescription($faker->paragraph(200));
        $decision->setCurrentPlace('opened');
        $decision->setCategory($this->getReference('category_' . $faker->numberBetween(0, 4)));
        $decision->setUser($this->getReference('user_0'));
        $this->addReference('decision_test_3', $decision);
        $manager->persist($decision);

        $decision = new Decision();
        $decision->setTitle('new test 4');
        $decision->setStartDate($faker->dateTimeBetween('-3 years', 'now'));
        $decision->setDescription($faker->paragraph(200));
        $decision->setCurrentPlace('opened');
        $decision->setCategory($this->getReference('category_' . $faker->numberBetween(0, 4)));
        $decision->setUser($this->getReference('user_0'));
        $this->addReference('decision_test_4', $decision);
        $manager->persist($decision);

        $decision = new Decision();
        $decision->setTitle('new test 5');
        $decision->setStartDate($faker->dateTimeBetween('-3 years', 'now'));
        $decision->setDescription($faker->paragraph(200));
        $decision->setCurrentPlace('opened');
        $decision->setCategory($this->getReference('category_' . $faker->numberBetween(0, 4)));
        $decision->setUser($this->getReference('user_0'));
        $this->addReference('decision_test_5', $decision);
        $manager->persist($decision);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
            UserFixtures::class,
        ];
    }
}
