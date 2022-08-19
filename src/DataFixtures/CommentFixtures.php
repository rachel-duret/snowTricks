<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $comment = new Comment();
        $comment->setUser($this->getReference('user_1'));
        $comment->setTrick($this->getReference('trick'));
        $comment->setComment('thats so cool');
        $comment->setCreateAt(new DateTimeImmutable());
        $manager->persist($comment);
        $manager->flush();
    }
}
