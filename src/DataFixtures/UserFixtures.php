<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $date = new \DateTimeImmutable;
        $user = new User();
        $user->setUsername('rachel');
        $user->setEmail('rachel@gmail.com');
        $user->setPassword('00000000');
        $user->setImagePath('https://media-exp1.licdn.com/dms/image/C5603AQHLrnBdt2OtYg/profile-displayphoto-shrink_200_200/0/1623077870969?e=1664409600&v=beta&t=AfkllQncf5lJq6c6ZTecaAZhL9JC5dk5NJlDXnOarKg');
        $user->setRole('admin');
        $user->setCreateAt($date);
        $manager->persist($user);
        

        $manager->flush();
    }
}
