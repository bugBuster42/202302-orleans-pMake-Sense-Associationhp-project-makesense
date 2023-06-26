<?php

namespace App\DataFixtures;

use App\Entity\UserSituation;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserSituationFixtures extends Fixture
{
    public const USER_SITUATION = [
        'Expert',
        'Impacté',
    ];

    public function load(ObjectManager $manager): void
    {

        foreach (self::USER_SITUATION as $key => $userSituationName) {
            $userSituation = new UserSituation();
            $userSituation->setName($userSituationName);
            $this->addReference('user_situation_' . $key, $userSituation);

            $manager->persist($userSituation);
        }

        $manager->flush();
    }
}
