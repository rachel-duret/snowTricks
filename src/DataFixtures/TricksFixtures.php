<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TricksFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $manager->flush();
    }
}
