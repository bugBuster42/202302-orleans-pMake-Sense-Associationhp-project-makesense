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
        $user->setFirstname('Gojo');
        $user->setLastname('Satoru');
        $user->setEmail('user@makesense.com');
        $user->setRoles(['ROLE_USER']);
        $this->addReference('user_0', $user);
        $hashedPassword = $this->passwordHasher->hashPassword($user, 'azertyuiop');
        $user->setPassword($hashedPassword);
        $manager->persist($user);

        $employee = new User();
        $employee->setFirstname('Kirua');
        $employee->setLastname('Zoldik');
        $employee->setEmail('employee@makesense.com');
        $employee->setRoles(['ROLE_EMPLOYEE']);
        $this->addReference('user_1', $user);
        $hashedPassword = $this->passwordHasher->hashPassword($employee, 'azertyuiop');
        $employee->setPassword($hashedPassword);
        $manager->persist($employee);

        $admin = new User();
        $admin->setFirstname('Gon');
        $admin->setLastname('Freecss');
        $admin->setEmail('admin@makesense.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $this->addReference('user_2', $user);
        $hashedPassword = $this->passwordHasher->hashPassword($admin, 'azertyuiop');
        $admin->setPassword($hashedPassword);
        $manager->persist($admin);

        $manager->flush();
    }
}
