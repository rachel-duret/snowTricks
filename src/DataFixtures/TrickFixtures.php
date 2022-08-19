<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TrickFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $trick = new Trick();
        $trick->setUser($this->getReference('user_1'));
        $trick->setCategory($this->getReference('category'));
        $trick->setTitle('mute');
        $trick->setDescription('This trick is good for beginner.');
        $trick->setCreatAt(new DateTimeImmutable());
        $manager->persist($trick);

        
        $trick1 = new Trick();
        $trick1->setUser($this->getReference('user_1'));
        $trick1->setCategory($this->getReference('category'));
        $trick1->setTitle('mute');
        $trick1->setDescription('This trick is good for beginner.');
        $trick1->setCreatAt(new DateTimeImmutable());
        $manager->persist($trick1);

        $manager->flush();


        $this->addReference('trick', $trick);
        $this->addReference('trick_1', $trick);
    }
}
