<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TricksFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
       $trick = new Trick();
       $trick->setTitle('test');
       $trick->setDescription('This a trick for kid');
    

        $manager->persist($trick);
    }
}
