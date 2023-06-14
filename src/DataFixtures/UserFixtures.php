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

        $employee = new User();
        $employee->setEmail('employee@makesense.com');
        $employee->setRoles(['ROLE_EMPLOYEE']);
        $hashedPassword = $this->passwordHasher->hashPassword($employee, 'azertyuiop');
        $employee->setPassword($hashedPassword);
        $manager->persist($employee);

        $admin = new User();
        $admin->setEmail('admin@makesense.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $this->passwordHasher->hashPassword($admin, 'azertyuiop');
        $admin->setPassword($hashedPassword);
        $manager->persist($admin);

        $manager->flush();
    }
}
