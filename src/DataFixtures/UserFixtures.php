<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const USER_ROLES = [
        'ROLE_USER',
        'USER_ADMIN',
        'USER_EMPLOYEE',
    ];

    public const  USER_NUMBER = 24;

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

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


        for ($i = 0; $i < self::USER_NUMBER; $i++) {
            $user = new User();
            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $user->setEmail($faker->email());
            $roles = [$this->getReference('user_' . $faker->numberBetween(0, count(self::USER_ROLES) - 1))];
            $user->setRoles($roles);

            $this->addReference('user_' . ($i + 3), $user);

            $hashedPassword = $this->passwordHasher->hashPassword($user, $faker->password());
            $user->setPassword($hashedPassword);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
