<?php

namespace App\DataFixtures;

use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StatusFixtures extends Fixture
{
    public const STATUS = [
        'Prise de décision commencée',
        'Première décision prise',
        'Conflit sur la décision',
        'Décision définitive',
        'Décision non aboutie',
        'Décision terminée'
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::STATUS as $statusName) {
            $status = new Status();
            $status->setName($statusName);
            $this->addReference('status_' . $statusName, $status);

            $manager->persist($status);
        }

        $manager->flush();
    }
}
