<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Helper\Constants;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    protected UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        foreach (Constants::USER_FIXTURES as $user) {
            $newUser = new User();
            $newUser->setName($user['name']);
            $newUser->setUsername($user['username']);
            $newUser->setEmail($user['username']);
            $newUser->setPassword($this->passwordHasher->hashPassword($newUser, $user['password']));

            $manager->persist($newUser);
        }

        $manager->flush();
    }
}