<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    ){}

    public function load(ObjectManager $manager): void
    {
        // Génére des utilisateurs
        $this->loadUsers($manager);
    }
    
    private function loadUsers(ObjectManager $manager): void
    {
        $data=["jp@mail.dev","bf@mail.dev"];

        foreach($data as $email){
            $user = new User();
            $user->setEmail($email);
            $user->setPassword($this->passwordHasher->hashPassword($user,'password'));
            $manager->persist($user);
        }
        $manager->flush();
    }


}
