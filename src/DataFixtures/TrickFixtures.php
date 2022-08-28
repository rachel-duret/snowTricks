<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;


class TrickFixtures extends Fixture implements DependentFixtureInterface

{
    public function load(ObjectManager $manager): void
    {
        //0
        $trick = new Trick();
        $trick->setUser($this->getReference('user_0'));
        $trick->setCategory($this->getReference('category_0'));
        $trick->setTitle('air');
        $trick->setDescription('A front jump, one of the basics.1.
        Accelerate, riding straight on a flat board.
        2.
        Before the jump, crouch down a little more and prepare for the launch.
        3.
        Pop off the jump with your back leg.
        4.
        Once you’re in the air, relax and watch your landing spot.
        5.
        Land, absorbing the impact with your legs.');
        $trick->setcreatedAt(new DateTimeImmutable());
        $manager->persist($trick);

        //1
        $trick1 = new Trick();
        $trick1->setUser($this->getReference('user_0'));
        $trick1->setCategory($this->getReference('category_0'));
        $trick1->setTitle('nollie');
        $trick1->setDescription('A jump you make by springing off the nose of the board.');
        $trick1->setcreatedAt(new DateTimeImmutable());
        $manager->persist($trick1);
        
        //2
        $trick2 = new Trick();
        $trick2->setUser($this->getReference('user_0'));
        $trick2->setCategory($this->getReference('category_0'));
        $trick2->setTitle('frontflip');
        $trick2->setDescription('Also called Tamedog. A cartwheel rotation over your leading shoulder performed from nollie.How do it
        The frontflip is one of the easiest flips on the snowboard.
        1.
        Before trying it out on the snow, practice the flip on a trampoline.
        2.
        Accelerate on a flat board. To get into a good spin, push onto the tail before the jump, and then quickly shift forward and push off with your front leg. Make sure your shoulders are parallel to the board.
        3.
        Once in the air, draw up your knees and find your landing spot.
        4.
        Land your board flat.');
        $trick2->setcreatedAt(new DateTimeImmutable());
        $manager->persist($trick2);

        //3
        $trick3 = new Trick();
        $trick3->setUser($this->getReference('user_0'));
        $trick3->setCategory($this->getReference('category_1'));
        $trick3->setTitle('nose');
        $trick3->setDescription('Front hand grabs the nose of the board.');
        $trick3->setcreatedAt(new DateTimeImmutable());
        $manager->persist($trick3);
        //4
        $trick4 = new Trick();
        $trick4->setUser($this->getReference('user_0'));
        $trick4->setCategory($this->getReference('category_1'));
        $trick4->setTitle('mute');
        $trick4->setDescription('Front hand grabs toe edge between the bindings.');
        $trick4->setcreatedAt(new DateTimeImmutable());
        $manager->persist($trick4);
        //5
        $trick5 = new Trick();
        $trick5->setUser($this->getReference('user_0'));
        $trick5->setCategory($this->getReference('category_1'));
        $trick5->setTitle('melon');
        $trick5->setDescription('Front hand grabs the heel edge between the bindings.');
        $trick5->setcreatedAt(new DateTimeImmutable());
        $manager->persist($trick5);
        //6
        $trick6 = new Trick();
        $trick6->setUser($this->getReference('user_0'));
        $trick6->setCategory($this->getReference('category_2'));
        $trick6->setTitle('fs boarfslide');
        $trick6->setDescription('Sliding down the obstacle with your board into a 90° position to the rail, facing uphill. Rail is between your bindings. You bring the nose over the rail during entry.');
        $trick6->setcreatedAt(new DateTimeImmutable());
        $manager->persist($trick6);
        //7
        $trick7 = new Trick();
        $trick7->setUser($this->getReference('user_0'));
        $trick7->setCategory($this->getReference('category_2'));
        $trick7->setTitle('fs lipslide');
        $trick7->setDescription('A slide in which you bring the tail over the rail during entry.
        1.
        Ride up just like you would doing a FS 50‑50.
        2.
        Snap and bring the rear of the board over the rail, supporting yourself on your back leg.
        3.
        Be careful not to catch the rail during entry. Give yourself some space and bring the board over the rail clean.');
        $trick7->setcreatedAt(new DateTimeImmutable());
        $manager->persist($trick7);
        //8
        $trick8 = new Trick();
        $trick8->setUser($this->getReference('user_0'));
        $trick8->setCategory($this->getReference('category_3'));
        $trick8->setTitle('hand plant');
        $trick8->setDescription('A mainstay of snowboarding photography.
        1.
        First off, you need to find a good quarter. You speed in the quarter should be high enough to perform a small backside jump.
        2.
        To achieve this, gradually shift your weight onto your back leg when approaching the edge. Then, once you reach the coping, pop off and simultaneously lower your arm, down to where your board was located a moment ago.
        3.
        The moment your board goes over the edge of the quarter, place your arm on the edge and look down into the quarter. Do not look at your board. With your head pointed downward, try to keep your legs bent and perform a grab.
        4.
        A melon grab works best here. Hold this position until the board touches the snow. Now straighten up and ride away.');
        $trick8->setcreatedAt(new DateTimeImmutable());
        $manager->persist($trick8);
        //9
        $trick9 = new Trick();
        $trick9->setUser($this->getReference('user_0'));
        $trick9->setCategory($this->getReference('category_3'));
        $trick9->setTitle('tail');
        $trick9->setDescription('Pressuring either the nose or tail so that the opposite end lifts off of the snow, allowing for a pivot-like spin while riding down the hill.');
        $trick9->setcreatedAt(new DateTimeImmutable());
        $manager->persist($trick9);


        $manager->flush();


        $this->addReference('trick_0', $trick);
        $this->addReference('trick_1', $trick1);
        $this->addReference('trick_2', $trick2);
        $this->addReference('trick_3', $trick3);
        $this->addReference('trick_4', $trick4);
        $this->addReference('trick_5', $trick5);
        $this->addReference('trick_6', $trick6);
        $this->addReference('trick_7', $trick7);
        $this->addReference('trick_8', $trick8);
        $this->addReference('trick_9', $trick9);
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            CategoryFixtures::class,
        ];
    }
}
