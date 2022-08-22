<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $category = new Category();
        $category->setName('backflip');
        $manager->persist($category);

        $category1 = new Category();
        $category1->setName('frontflip');
        $manager->persist($category1);

        $manager->flush();

        $this->addReference('category', $category);
    }
}
