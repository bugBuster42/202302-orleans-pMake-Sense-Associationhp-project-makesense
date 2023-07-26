<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\DecisionFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public const COMMENT_NUMBER = 50;
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::COMMENT_NUMBER; $i++) {
            $comment = new Comment();
            $comment->setText($faker->sentence(50));
            $comment->setDecision(
                $this->getReference('decision_' . $faker->numberBetween(0, DecisionFixtures::DECISION_NUMBER - 1))
            );
            $comment->setUser($this->getReference('user_' . $faker->numberBetween(0, 2)));
            $manager->persist($comment);

            $manager->flush();
        }

        for ($i = 0; $i < 5; $i++) {
            $comment = new Comment();
            $comment->setText($faker->sentence(50));
            $comment->setDecision(
                $this->getReference('decision_test')
            );
            $comment->setUser($this->getReference('user_' . $faker->numberBetween(3, UserFixtures::USER_NUMBER)));
            $manager->persist($comment);

            $manager->flush();
        }

        for ($i = 0; $i < 5; $i++) {
            $comment = new Comment();
            $comment->setText($faker->sentence(50));
            $comment->setDecision(
                $this->getReference('decision_test_2')
            );
            $comment->setUser($this->getReference('user_' . $faker->numberBetween(3, UserFixtures::USER_NUMBER)));
            $manager->persist($comment);

            $manager->flush();
        }

        for ($i = 0; $i < 5; $i++) {
            $comment = new Comment();
            $comment->setText($faker->sentence(50));
            $comment->setDecision(
                $this->getReference('decision_test_3')
            );
            $comment->setUser($this->getReference('user_' . $faker->numberBetween(3, UserFixtures::USER_NUMBER)));
            $manager->persist($comment);

            $manager->flush();
        }

        for ($i = 0; $i < 5; $i++) {
            $comment = new Comment();
            $comment->setText($faker->sentence(50));
            $comment->setDecision(
                $this->getReference('decision_test_4')
            );
            $comment->setUser($this->getReference('user_' . $faker->numberBetween(3, UserFixtures::USER_NUMBER)));
            $manager->persist($comment);

            $manager->flush();
        }

        for ($i = 0; $i < 5; $i++) {
            $comment = new Comment();
            $comment->setText($faker->sentence(50));
            $comment->setDecision(
                $this->getReference('decision_test_5')
            );
            $comment->setUser($this->getReference('user_' . $faker->numberBetween(3, UserFixtures::USER_NUMBER)));
            $manager->persist($comment);

            $manager->flush();
        }
    }
    public function getDependencies(): array
    {
        return [

            UserFixtures::class,
            DecisionFixtures::class
        ];
    }
}
