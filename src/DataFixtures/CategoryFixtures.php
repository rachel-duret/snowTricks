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
        $category->setName('junps spins');
        $manager->persist($category);

        $category1 = new Category();
        $category1->setName('grabs');
        $manager->persist($category1);

        $category2 = new Category();
        $category2->setName('jibbing');
        $manager->persist($category2);

        $category3 = new Category();
        $category3->setName('flat');
        $manager->persist($category3);

        $manager->flush();

        $this->addReference('category_0', $category);
        $this->addReference('category_1', $category);
        $this->addReference('category_2', $category);
        $this->addReference('category_3', $category);
    }
}
