<?php

namespace App\DataFixtures;

use App\Entity\Sheet1;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $product = new Sheet1();
            $product->setVarName("var$i");
            $product->setCell(rand(0,9));
            $manager->persist($product);
        }

        $manager->flush();
    }
}
