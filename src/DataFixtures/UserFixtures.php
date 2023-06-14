<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('user@makesense.com');
        $user->setRoles(['ROLE_USER']);
        $hashedPassword = $this->passwordHasher->hashPassword($user, 'azertyuiop');
        $user->setPassword($hashedPassword);
        $manager->persist($user);

        $employe = new User();
        $employe->setEmail('employe@makesense.com');
        $employe->setRoles(['ROLE_EMPLOYE']);
        $hashedPassword = $this->passwordHasher->hashPassword($employe, 'azertyuiop');
        $employe->setPassword($hashedPassword);
        $manager->persist($employe);

        $admin = new User();
        $admin->setEmail('admin@makesense.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $this->passwordHasher->hashPassword($admin, 'azertyuiop');
        $admin->setPassword($hashedPassword);
        $manager->persist($admin);

        $manager->flush();
    }
}
