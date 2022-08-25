<?php

namespace App\DataFixtures;

use App\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class VideoFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
       $video = new Video();
       $video->setTrick($this->getReference('trick_0'));
       $video->setVideoPath('https://st.ride.ru/user_content/video/100288_320_f1OG0b.mp4');
       $manager->persist($video);

       
       $video1 = new Video();
       $video1->setTrick($this->getReference('trick_1'));
       $video1->setVideoPath('https://st.ride.ru/user_content/video/113951_320_P8ymHM.mp4');
       $manager->persist($video1);

       $video2 = new Video();
       $video2->setTrick($this->getReference('trick_2'));
       $video2->setVideoPath('https://st.ride.ru/user_content/video/113951_320_P8ymHM.mp4');
       $manager->persist($video2);

       $video3 = new Video();
       $video3->setTrick($this->getReference('trick_3'));
       $video3->setVideoPath('https://st.ride.ru/user_content/video/141126_320_6OnWJr.mp4');
       $manager->persist($video3);

       $video4 = new Video();
       $video4->setTrick($this->getReference('trick_4'));
       $video4->setVideoPath('https://st.ride.ru/user_content/video/39906_320_91z8rR.mp4');
       $manager->persist($video4);

       $video5 = new Video();
       $video5->setTrick($this->getReference('trick_5'));
       $video5->setVideoPath('https://st.ride.ru/user_content/video/104255_320_ZZBvb4.mp4');
       $manager->persist($video5);

       $video6 = new Video();
       $video6->setTrick($this->getReference('trick_6'));
       $video6->setVideoPath('https://st.ride.ru/user_content/video/132135_320_DmpoYZ.mp4');
       $manager->persist($video6);

       $video7 = new Video();
       $video7->setTrick($this->getReference('trick_7'));
       $video7->setVideoPath('https://st.ride.ru/user_content/video/145268_320_QFQkZv.mp4');
       $manager->persist($video7);

       $video8 = new Video();
       $video8->setTrick($this->getReference('trick_8'));
       $video8->setVideoPath('https://st.ride.ru/user_content/video/40384_320_xZwTVi.mp4');
       $manager->persist($video8);

       $video9 = new Video();
       $video9->setTrick($this->getReference('trick_9'));
       $video9->setVideoPath('https://st.ride.ru/user_content/video/174453_320_54Agw7.mp4');
       $manager->persist($video9);
       


        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TrickFixtures::class,
        ];
    }
}
