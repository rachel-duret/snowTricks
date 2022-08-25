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
        $image->setTrick($this->getReference('trick_0'));
        $image->setImagePath('https://ucarecdn.com/6485bb9b-999f-485c-9589-46bf41cda121/-/sharp/3/-/format/jpeg/-/progressive/yes/-/quality/normal/-/scale_crop/622x622/center/');
        $manager->persist($image);

          
        $image1 = new Image();
        $image1->setTrick($this->getReference('trick_1'));
        $image1->setImagePath('https://ucarecdn.com/6c64c906-4f88-4c98-a3c0-9b273d40300b/-/sharp/3/-/format/jpeg/-/progressive/yes/-/quality/normal/-/scale_crop/622x622/center/');
        $manager->persist($image1);

            
        $image2 = new Image();
        $image2->setTrick($this->getReference('trick_2'));
        $image2->setImagePath('https://ucarecdn.com/7f5b1c43-edc6-466e-9677-5bb86f31a78e/-/sharp/3/-/format/jpeg/-/progressive/yes/-/quality/normal/-/scale_crop/622x544/center/');
        $manager->persist($image2);

        $image3 = new Image();
        $image3->setTrick($this->getReference('trick_3'));
        $image3->setImagePath('https://ucarecdn.com/fd0f783e-f7af-4dcd-bc19-a4c999c69ac2/-/sharp/3/-/format/jpeg/-/progressive/yes/-/quality/normal/-/scale_crop/622x622/center/');
        $manager->persist($image3);

        $image4 = new Image();
        $image4->setTrick($this->getReference('trick_4'));
        $image4->setImagePath('https://ucarecdn.com/97cd958f-5f00-45af-94f7-137ee5992262/-/sharp/3/-/format/jpeg/-/progressive/yes/-/quality/normal/-/scale_crop/622x622/center/');
        $manager->persist($image4);

        $image5 = new Image();
        $image5->setTrick($this->getReference('trick_5'));
        $image5->setImagePath('https://ucarecdn.com/89fbc372-c707-4f5f-9ca4-dce98c2981a7/-/sharp/3/-/format/jpeg/-/progressive/yes/-/quality/normal/-/scale_crop/622x622/center/');
        $manager->persist($image5);

        $image6 = new Image();
        $image6->setTrick($this->getReference('trick_6'));
        $image6->setImagePath('https://ucarecdn.com/ca72dde4-423e-47cf-9405-b9a682cb9f85/-/sharp/3/-/format/jpeg/-/progressive/yes/-/quality/normal/-/scale_crop/622x415/center/');
        $manager->persist($image6);

        $image7 = new Image();
        $image7->setTrick($this->getReference('trick_7'));
        $image7->setImagePath('https://ucarecdn.com/6992b315-e8d1-4b9e-bb10-db20d5ba06fc/-/sharp/3/-/format/jpeg/-/progressive/yes/-/quality/normal/-/scale_crop/622x415/center/');
        $manager->persist($image7);

        $image8 = new Image();
        $image8->setTrick($this->getReference('trick_8'));
        $image8->setImagePath('https://ucarecdn.com/3821e6b1-1483-417d-a544-a7c8a0463913/-/sharp/3/-/format/jpeg/-/progressive/yes/-/quality/normal/-/scale_crop/622x544/center/');
        $manager->persist($image8);

        $image9 = new Image();
        $image9->setTrick($this->getReference('trick_9'));
        $image9->setImagePath('https://ucarecdn.com/c9a05731-e950-4942-a576-1cc390082f30/-/sharp/3/-/format/jpeg/-/progressive/yes/-/quality/normal/-/scale_crop/622x544/center/');
        $manager->persist($image9);
        
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TrickFixtures::class,
        ];
    }

}
