<?php

namespace App\DataFixtures;

use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ImageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $image = new Image();
        $image->setTrick($this->getReference('trick'));
        $image->setImagePath('https://ucarecdn.com/b52345ab-9dff-44ac-89f0-dc724755c5a7/-/sharp/3/-/format/jpeg/-/progressive/yes/-/quality/normal/-/scale_crop/355x200/center/');
        $manager->persist($image);

        
        $image1 = new Image();
        $image1->setTrick($this->getReference('trick'));
        $image1->setImagePath('https://ucarecdn.com/4fa63f21-9b6c-4766-a63e-4804f2d6a4d0/-/sharp/3/-/format/jpeg/-/progressive/yes/-/quality/normal/-/scale_crop/355x200/center/');
        $manager->persist($image1);
        
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TrickFixtures::class,
        ];
    }

}
