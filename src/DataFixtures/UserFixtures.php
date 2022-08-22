<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordEncoder)
    {
        
    }
    public function load(ObjectManager $manager): void
    {
       $user = new User();
       $user->setEmail('example@gmail.com');
       $user->setRoles(['ROLE_USER']);
       $user->setPassword(
        $this->passwordEncoder->hashPassword($user, 'password')
       );
       $user->setImage('https://static.vecteezy.com/ti/vecteur-libre/t2/1993889-belle-femme-latine-avatar-icone-personnage-gratuit-vectoriel.jpg');
       $user->setUsername('lara');
       $user->setToken(NULL);
       $user->setIsVerified(true);
       $manager->persist($user);

       $user1 = new User();
       $user1->setEmail('example1@gmail.com');
       $user1->setRoles(['ROLE_USER']);
       $user1->setPassword(
        $this->passwordEncoder->hashPassword($user1, 'password')
       );
       $user1->setImage('https://static.vecteezy.com/ti/vecteur-libre/t2/1993889-belle-femme-latine-avatar-icone-personnage-gratuit-vectoriel.jpg');
       $user1->setUsername('lara1');
       $user1->setToken(NULL);
       $user1->setIsVerified(true);
       $manager->persist($user1);

        $manager->flush();

        $this->addReference('user', $user);
        $this->addReference('user_1', $user);
    }
}
