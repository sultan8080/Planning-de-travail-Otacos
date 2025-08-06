<?php

namespace App\DataFixtures;

use App\Entity\Branch;
use App\Entity\ShiftType;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}

    public function load(ObjectManager $manager): void
    {
        // 1. Create Branch
        $branch = new Branch();
        $branch->setName('Château Thierry');
        $branch->setAddress('02400, Château Thierry');
        $manager->persist($branch);

        // 2. Create Users
        $usersData = [
            ['admin@example.com', ['ROLE_ADMIN'], 'Admin', 'Super'],
            ['manager@example.com', ['ROLE_MANAGER'], 'Manager', 'Team'],
            ['employee1@example.com', ['ROLE_EMPLOYEE'], 'Doe', 'John'],
            ['employee2@example.com', ['ROLE_EMPLOYEE'], 'Smith', 'Anna'],
            ['employee3@example.com', ['ROLE_EMPLOYEE'], 'Brown', 'James'],
            ['employee4@example.com', ['ROLE_EMPLOYEE'], 'Taylor', 'Emily'],
            ['employee5@example.com', ['ROLE_EMPLOYEE'], 'Wilson', 'David'],
        ];

        foreach ($usersData as [$email, $roles, $nom, $prenom]) {
            $user = new User();
            $user->setEmail($email);
            $user->setRoles($roles);
            $user->setNom($nom);
            $user->setPrenom($prenom);
            $user->setBranch($branch);
            $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
            $manager->persist($user);
        }

        // 3. Create ShiftTypes
        $shiftTypes = [
            ['Le Matin', '11:00', '14:00'],
            ['Caisse', '10:30', '18:00'],
            ['Cuisine', '9:30', '18:00'],
            ['le soir', '18:00', '23:30'],
            ['V/S-soir', '18:00', '00:30'],
        ];

        foreach ($shiftTypes as [$name, $start, $end]) {
            $shiftType = new ShiftType();
            $shiftType->setShiftName($name);
            $shiftType->setDefaultStart(new \DateTimeImmutable($start));
            $shiftType->setDefaultEnd(new \DateTimeImmutable($end));
            $manager->persist($shiftType);
        }

        $manager->flush();
    }
}
