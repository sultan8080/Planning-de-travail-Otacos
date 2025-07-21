<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}

    public function load(ObjectManager $manager): void
    {
        // Admin
        $admin = new User();
        $admin->setEmail('admin@fastfood.fr');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setNom('Admin');
        $admin->setPrenom('Chief');
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'adminpass'));
        $manager->persist($admin);

        // Manager
        $managerUser = new User();
        $managerUser->setEmail('manager@fastfood.fr');
        $managerUser->setRoles(['ROLE_MANAGER']);
        $managerUser->setNom('Manager');
        $managerUser->setPrenom('Coordinator');
        $managerUser->setPassword($this->passwordHasher->hashPassword($managerUser, 'managerpass'));
        $manager->persist($managerUser);

        // Employee
        $employee = new User();
        $employee->setEmail('employee@fastfood.fr');
        $employee->setRoles(['ROLE_EMPLOYEE']);
        $employee->setNom('Employee');
        $employee->setPrenom('Crew');
        $employee->setPassword($this->passwordHasher->hashPassword($employee, 'employeepass'));
        $manager->persist($employee);

   
        $manager->flush();
    }
}