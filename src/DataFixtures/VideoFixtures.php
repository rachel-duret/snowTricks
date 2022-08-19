<?php

namespace App\DataFixtures;

use App\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VideoFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
       $video = new Video();
       $video->setTrick($this->getReference('trick'));
       $video->setVideoPath('https://st.ride.ru/user_content/video/100288_320_f1OG0b.mp4');
       $manager->persist($video);

       $video1 = new Video();
       $video1->setTrick($this->getReference('trick'));
       $video1->setVideoPath('https://st.ride.ru/user_content/video/113951_320_P8ymHM.mp4');
       $manager->persist($video1);

        $manager->flush();
    }
}
