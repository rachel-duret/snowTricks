<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $comment = new Comment();
        $comment->setUser($this->getReference('user_1'));
        $comment->setTrick($this->getReference('trick_0'));
        $comment->setComment('thats so cool');
        $comment->setCreateAt(new DateTimeImmutable());
        $manager->persist($comment);

        $comment1 = new Comment();
        $comment1->setUser($this->getReference('user_2'));
        $comment1->setTrick($this->getReference('trick_0'));
        $comment1->setComment('thats so cool');
        $comment1->setCreateAt(new DateTimeImmutable());
        $manager->persist($comment1);

        
        $comment2 = new Comment();
        $comment2->setUser($this->getReference('user_3'));
        $comment2->setTrick($this->getReference('trick_0'));
        $comment2->setComment('thats so cool');
        $comment2->setCreateAt(new DateTimeImmutable());
        $manager->persist($comment2);

        
        $comment3 = new Comment();
        $comment3->setUser($this->getReference('user_4'));
        $comment3->setTrick($this->getReference('trick_0'));
        $comment3->setComment('thats so cool');
        $comment3->setCreateAt(new DateTimeImmutable());
        $manager->persist($comment3);

        
        $comment4 = new Comment();
        $comment4->setUser($this->getReference('user_5'));
        $comment4->setTrick($this->getReference('trick_0'));
        $comment4->setComment('thats so cool');
        $comment4->setCreateAt(new DateTimeImmutable());
        $manager->persist($comment4);

        
        $comment5 = new Comment();
        $comment5->setUser($this->getReference('user_6'));
        $comment5->setTrick($this->getReference('trick_0'));
        $comment5->setComment('thats so cool');
        $comment5->setCreateAt(new DateTimeImmutable());
        $manager->persist($comment5);

        
        $comment6 = new Comment();
        $comment6->setUser($this->getReference('user_7'));
        $comment6->setTrick($this->getReference('trick_0'));
        $comment6->setComment('thats so cool');
        $comment6->setCreateAt(new DateTimeImmutable());
        $manager->persist($comment6);

        
        $comment7 = new Comment();
        $comment7->setUser($this->getReference('user_8'));
        $comment7->setTrick($this->getReference('trick_0'));
        $comment7->setComment('thats so cool');
        $comment7->setCreateAt(new DateTimeImmutable());
        $manager->persist($comment7);

        
        $comment8 = new Comment();
        $comment8->setUser($this->getReference('user_9'));
        $comment8->setTrick($this->getReference('trick_0'));
        $comment8->setComment('thats so cool');
        $comment8->setCreateAt(new DateTimeImmutable());
        $manager->persist($comment8);

        
        $comment9 = new Comment();
        $comment9->setUser($this->getReference('user_0'));
        $comment9->setTrick($this->getReference('trick_0'));
        $comment9->setComment('thats so cool');
        $comment9->setCreateAt(new DateTimeImmutable());
        $manager->persist($comment9);

        
        $comment10 = new Comment();
        $comment10->setUser($this->getReference('user_2'));
        $comment10->setTrick($this->getReference('trick_0'));
        $comment10->setComment('thats so cool');
        $comment10->setCreateAt(new DateTimeImmutable());
        $manager->persist($comment10);




        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            UserFixtures::class,
            TrickFixtures::class
        ];
    }

}
